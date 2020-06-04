<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\SambaUploadRequest;
use App\Http\Requests\SambaProjectCreateRequest;
use App\Repositories\ActivityRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use App\SambaName;
use DB;
use App\SambaUser;
use App\User;
use App\Project;
use App\Activity;
use Auth;
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportExcelToArray;


class SambaUserUploadController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository, ProjectRepository $projectRepository, ActivityRepository $activityRepository)
    {
        $this->userRepository = $userRepository;
        $this->projectRepository = $projectRepository;
        $this->activityRepository = $activityRepository;
    }

    public function getForm()
    {
        return view('dataFeed/sambauserupload');
    }

    public function postForm(SambaUploadRequest $request)
    {
        $color = [
            'error' => 'text-danger',
            'info' => 'text-info',
            'update' => 'text-warning',
            'add' => 'text-primary',
        ];

        $result = new \stdClass();
        $result->result = 'success';
        $result->msg = '';

        $messages = [];
        $messages_only_errors = [];

        //First we need to get all employees for this manager
        $all_users = $this->userRepository->getAllUsersFromManager(Auth::user()->id);
        // Then we extract only the ids of the users reporting to the auth user
        $users_select = [];
        foreach ($all_users as $key => $user) {
            $users_select[$user['id']] = $user['name'];
        }
        //dd($users_select);
        //dd($request->create_in_db);
        $file = $request->file('uploadfile');
        if ($file->isValid()) {
            $filename = $file->getClientOriginalName();
            $fileextension = $file->getClientOriginalExtension();

            if ($fileextension != 'csv') {
                array_push($messages, ['status'=>'error', 'msg'=>'The only extension authorized is CSV']);
                $messages_only_errors = $messages;

                return view('dataFeed/sambauserupload', compact('messages_only_errors', 'messages', 'color'));
            }
            // In case we send a CSV file, the worksheet name is : Worksheet
            $reader = new ImportExcelToArray();
            $reader->startingRow = 1;
            $temp = Excel::import($reader,$file);
            //dd($reader->sheetData);
            $result = $reader->sheetData['Worksheet'];

            // Now we need to check we have the right columns
            $headerRow = $reader->getHeaders('Worksheet');

            //dd($headerRow);
            $columns_needed = [
                'owners_sales_cluster',
                'account_name',
                'stage',
                'opportunity_name',
                'public_opportunity_id',
                'created_date',
                'close_date',
                'amount_tcv_converted_currency',
                'amount_tcv_converted', 
                'team_member_name', 
            ];

            //print_r($headerRow);echo "</BR>";print_r($columns_needed);die();
            //dd($headerRow);

            // If the columns are not all present then we have an error and go back
            if (!$reader->checkMinHeaders('Worksheet',$columns_needed)) {
                array_push($messages, ['status'=>'error', 'msg'=>'Some columns are required but not present in the file, please see the sample file and upload again.']);
                $messages_only_errors = $messages;

                return view('dataFeed/sambauserupload', compact('messages_only_errors', 'messages', 'color'));
            }

            // This command helps getting a view on what we get from $sheet
            //$sheet->dd();

            //dd($result);
            // First we need to modify the dates so that they will be understandable by MySQL
            foreach ($result as &$row) {
                $myDateTime = DateTime::createFromFormat('m/d/Y', $row['created_date']);
                if (is_object($myDateTime)) {
                    $row['created_date'] = $myDateTime->format('Y-m-d');
                }

                $myDateTime = DateTime::createFromFormat('m/d/Y', $row['close_date']);
                if (is_object($myDateTime)) {
                    $row['close_date'] = $myDateTime->format('Y-m-d');
                }
            }

            unset($row);

            //dd($result);

            $ids = [];

            $missing_users = [];

            // Here we go over each row and we create a new file that will aggregate all the rows in a single row from the different products on the same CL ID
            foreach ($result as $row) {
                // First we check if the Samba opp id is empty and if yes, we don't need to execute the script for this line
                if ($row['public_opportunity_id'] == '') {
                    continue;
                }

                $user = User::where('name',$row['team_member_name'])->first();

                if ($user == null) {
                    $user_cl = SambaUser::where('samba_name',$row['team_member_name'])->first();
                    if ($user_cl == null) {
                        // If we cannot find the user then we need to update the db with the name in dolphin
                        if (!in_array($row['team_member_name'],$missing_users)) {
                            array_push($ids, [
                                'owners_sales_cluster' => '',
                                'account_name' => '',
                                'account_name_modified' => '',
                                'account_name_modified_id' => 0,
                                'public_opportunity_id' => $row['public_opportunity_id'],
                                'opportunity_name' => '',
                                'created_date' => '',
                                'close_date' => '',
                                'stage' => '',
                                'amount_tcv' => '',
                                'user_id' => 0,
                                'user_name' => $row['team_member_name'],
                                'user_assigned' => false,
                                'in_db' => false,
                                'color' => '',
                            ]);
                            array_push($missing_users,$row['team_member_name']);
                        }
                        continue;
                    } else {
                        $user = User::where('name',$user_cl->dolphin_name)->first();
                    }
                    
                }

                $project_count = DB::table('projects')
                    ->select(
                        'projects.id',
                        'projects.samba_id',
                        'activities.user_id'
                    )
                    ->leftjoin('activities', 'activities.project_id', '=', 'projects.id')
                    ->where('projects.samba_id', '=', $row['public_opportunity_id'])
                    ->where('activities.user_id', '=', $user->id)
                    ->count();
                
                if ($project_count > 0) {
                    continue;
                }



                $projectInDB = $this->projectRepository->getBySambaID($row['public_opportunity_id']);

                // Checking if the project is in DB
                if (count($projectInDB) < 1) {
                    // Samba ID not found in DB
                    $in_db = false;
                } else {
                    // Samba ID found in DB
                    $in_db = true;
                }

                if ($row['stage'] == 'Closed Won') {
                    $color = 'success';
                } elseif ($row['stage'] == 'Closed Lost') {
                    $color = 'danger';
                } else {
                    $color = '';
                }
                array_push($ids, [
                    'owners_sales_cluster' => $row['owners_sales_cluster'],
                    'account_name' => $row['account_name'],
                    'account_name_modified' => $row['account_name'],
                    'account_name_modified_id' => 0,
                    'public_opportunity_id' => $row['public_opportunity_id'],
                    'opportunity_name' => $row['opportunity_name'],
                    'created_date' => $row['created_date'],
                    'close_date' => $row['close_date'],
                    'stage' => $row['stage'],
                    'amount_tcv' => $row['amount_tcv_converted'],
                    'user_id' => $user->id,
                    'user_name' => $row['team_member_name'],
                    'user_assigned' => false,
                    'in_db' => $in_db,
                    'color' => $color,
                ]);
                
            }
            //dd($ids);


            foreach ($ids as &$row) {
                $check_customer_name = Customer::where('name',$row['account_name'])->first();
                if ($check_customer_name != null) {
                    $row['account_name_modified_id'] = $check_customer_name->id;
                } else {
                    $name = SambaName::where('samba_name', $row['account_name'])->first();
                    if ($name != null) {
                        $customer_id = Customer::where('name',$name->dolphin_name)->first();
                        $row['account_name_modified'] = $name->dolphin_name;
                        if ($customer_id) {
                            $row['account_name_modified_id'] = $customer_id->id;
                        }
                    }
                }
            }
            unset($row);

            //dd($ids);
        }

        foreach ($messages as $message) {
            if ($message['status'] == 'error') {
                array_push($messages_only_errors, $message);
            }
        }
        \Session::flash('success', 'File uploaded');

        $customers_list = Customer::orderBy('name')->pluck('name', 'id');
        $customers_list->prepend('', '');

        $table_height = Auth::user()->table_height;

        $create_records = true;

        return view('dataFeed/sambauserupload', compact('messages_only_errors', 'messages', 'create_records','color', 'customers_list', 'users_select', 'ids', 'table_height'));
    }

    public function sambaUploadCreateUser(Request $request)
    {
        // First we need to validate the data we received
        $data = $request->validate([
            'user_id' => 'required'
        ]);

        $result = new \stdClass();
        $inputs = $request->all();
        $user = User::find($inputs['user_id']);

        // Create a record
        if (Auth::user()->can('samba-upload')) {
            $samba_user = new SambaUser;
            $samba_user->samba_name = $inputs['cl_user_name'];
            $samba_user->dolphin_name = $user->name;
            $samba_user->save();
            $result->result = 'success';
            $result->msg = 'Record updated successfully';
        } else {
            $result->result = 'error';
            $result->msg = 'No permission to update record';
        }

        return json_encode($result);

    }

    public function sambaUploadUpdateProject(Request $request, $project_id = null)
    {
        $result = new \stdClass();
        $inputs = $request->all();
        // Update a record
        $update_result = Project::find($project_id);
        if (Auth::user()->can('tools-all_projects-edit')) {
            $update_result->update($inputs);
            $result->result = 'success';
            $result->msg = 'Record updated successfully';
        } else {
            $result->result = 'error';
            $result->msg = 'No permission to update record';
        }

        return json_encode($result);

    }

    public function sambaUploadCreateProject(SambaProjectCreateRequest $request)
    {
        $result = new \stdClass();
        $inputs = $request->all();

        //dd($inputs);

        // We need to check if we need to enter a relation between the name from CL and the name in Dolphin
        $dolphin_name = Customer::find($inputs['customer_id'])->name;
        if ($dolphin_name != $inputs['customer_cl']) {
            $name = SambaName::where('samba_name', $inputs['customer_cl'])->first();
            if ($name == null) {
                $name = new SambaName;
                $name->samba_name = $inputs['customer_cl'];
                $name->dolphin_name = $dolphin_name;
                $name->save();
            }
        }

        if (Auth::user()->can('tools-all_projects-edit')) {
            $project = new Project;
            $project->project_name = $inputs['project_name'];
            $project->customer_id = $inputs['customer_id'];
            $project->project_type = 'Pre-sales';
            $project->samba_id = $inputs['samba_id'];
            $project->created_by_user_id = Auth::user()->id;
            $project->save();

            $activity = new Activity;
            $activity->year = $inputs['year'];
            $activity->month = 1;
            $activity->project_id = $project->id;
            $activity->user_id = $inputs['user_id'];
            $activity->task_hour = 0;
            $activity->from_otl = 0;
            $activity->save();

            $result->result = 'success';
            $result->msg = 'Record updated successfully';
        } else {
            $result->result = 'error';
            $result->msg = 'No permission to update record';
        }

        return json_encode($result);
        
    }
}

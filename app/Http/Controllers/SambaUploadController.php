<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\SambaUploadRequest;
use App\Http\Requests\SambaProjectCreateRequest;
use App\Repositories\ActivityRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use App\SambaName;
use App\Project;
use App\Activity;
use Auth;
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportExcelToArray;


class SambaUploadController extends Controller
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
        return view('dataFeed/sambaupload');
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

                return view('dataFeed/sambaupload', compact('messages_only_errors', 'messages', 'color'));
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
                'opportunity_domain',
                'account_name',
                'opportunity_name',
                'public_opportunity_id',
                'opportunity_owner',
                'created_date',
                'close_date',
                'stage',
                'probability',
                'amount_tcv_converted_currency',
                'amount_tcv_converted', 
            ];

            //print_r($headerRow);echo "</BR>";print_r($columns_needed);die();
            //dd($headerRow);

            // If the columns are not all present then we have an error and go back
            if (!$reader->checkMinHeaders('Worksheet',$columns_needed)) {
                array_push($messages, ['status'=>'error', 'msg'=>'Some columns are required but not present in the file, please see the sample file and upload again.']);
                $messages_only_errors = $messages;

                return view('dataFeed/sambaupload', compact('messages_only_errors', 'messages', 'color'));
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

                $row['probability'] = intval($row['probability']);
            }

            unset($row);

            //dd($result);

            // $i corresponds to the line in the excel file and because the column title is on line 1, we start with $i = 2
            $i = 2;

            $ids = [];

            // Here we go over each row and we create a new file that will aggregate all the rows in a single row from the different products on the same CL ID
            foreach ($result as $row) {
                // First we check if the Samba opp id is empty and if yes, we don't need to execute the script for this line
                if ($row['public_opportunity_id'] == '') {
                    continue;
                }

                $projectInDB = $this->projectRepository->getBySambaID($row['public_opportunity_id']);

                //dd(count($projectInDB));

                // Checking if the project is in DB
                if (count($projectInDB) < 1) {
                    // Samba ID not found in DB
                    array_push($messages, ['status'=>'error',
                        'msg'=>'LINE '.$i.': '.' <b>Customer</b>: <u>'.$row['account_name'].'</u> / <b>Opportunity</b>: <u>'.$row['opportunity_name'].'</u> / <b>Samba ID</b>: <u>'.$row['public_opportunity_id'].'</u>'.' -> this Samba ID is not found in the DB or it is associated to a project that is not a project type set as Pre-sales.',
                    ]);
                    $in_db = false;
                } else {
                    // Samba ID found in DB
                    array_push($messages, ['status'=>'info',
                        'msg'=>'LINE '.$i.': Found '.count($projectInDB).' instance of Samba ID:'.$row['public_opportunity_id']
                    ]);
                    $in_db = true;
                }
                $i += 1;

                // Now we need to check if this is consulting revenue or not
                if (isset($row['product_tcv_converted']) && isset($row['product_name'])) {
                    if (strpos($row['product_name'], 'Consulting') !== false || strpos($row['product_name'], 'consulting') !== false) {
                        $consulting_tcv = $row['product_tcv_converted'];
                    } else {
                        $consulting_tcv = 0;
                    }
                } else {
                    $consulting_tcv = null;
                }

                if (in_array($row['public_opportunity_id'], array_column($ids, 'public_opportunity_id'))) {
                    $key = array_search($row['public_opportunity_id'], array_column($ids, 'public_opportunity_id'));
                    if ($consulting_tcv != null) {
                        $ids[$key]['consulting_tcv'] = $ids[$key]['consulting_tcv'] + $consulting_tcv;
                    }
                    continue;
                } else {
                    if ($row['stage'] == 'Closed Won') {
                        $color = 'success';
                    } elseif ($row['stage'] == 'Closed Lost') {
                        $color = 'danger';
                    } else {
                        $color = '';
                    }
                    array_push($ids, [
                        'owners_sales_cluster' => $row['owners_sales_cluster'],
                        'opportunity_domain' => $row['opportunity_domain'],
                        'account_name' => $row['account_name'],
                        'account_name_modified' => $row['account_name'],
                        'account_name_modified_id' => 0,
                        'public_opportunity_id' => $row['public_opportunity_id'],
                        'opportunity_name' => $row['opportunity_name'],
                        'opportunity_owner' => $row['opportunity_owner'],
                        'created_date' => $row['created_date'],
                        'close_date' => $row['close_date'],
                        'stage' => $row['stage'],
                        'probability' => $row['probability'],
                        'amount_tcv' => $row['amount_tcv_converted'],
                        'consulting_tcv' => $consulting_tcv,
                        'user_id' => 0,
                        'user_name' => 'no user from your team',
                        'in_db' => $in_db,
                        'color' => $color,
                    ]);
                }
            }
            //dd($ids);


            foreach ($ids as &$row) {
                if ($row['in_db']) {
                    $projectInDB = Project::with('activities.user')->where('samba_id',$row['public_opportunity_id'])->get();
                    foreach ($projectInDB as $key => $project) {
                        $customer = $project->customer()->first();
                        //dd($row['probability']);
                        array_push($messages, ['status'=>'update',
                            'msg'=>'LINE '.$i.': '.
                            ' <b>Customer</b>: <u>'.$customer->name.'</u> / <b>Opportunity</b>: <u>'.$project->project_name.'</u> / <b>Samba ID</b>: <u>'.$row['public_opportunity_id'].'</u>'.' -> project updated in the DB.'
                        ]);
                        $project->samba_lead_domain = $row['opportunity_domain'];
                        $project->samba_opportunit_owner = $row['opportunity_owner'];
                        $project->samba_stage = $row['stage'];
                        $project->win_ratio = intval($row['probability']);
                        $project->revenue = $row['amount_tcv'];
                        $project->estimated_start_date = $row['created_date'];
                        $project->estimated_end_date = $row['close_date'];
                        if ($row['consulting_tcv'] != null) {
                            $project->samba_consulting_product_tcv = $row['consulting_tcv'];
                        }
                        $project->save();
                        // Now we need to look in our team who is assigned on this project
                        $user_names = $project->activities->unique('name')->pluck('user.name','user.id');
                        foreach ($user_names as $key => $user_name) {
                            if (in_array($user_name,$users_select)) {
                                $row['user_id'] = $key;
                                $row['user_name'] = $user_name;
                            }
                            continue;
                        }
                    }
                } else {
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

        if ($request->create_in_db == "on") {
            $create_records = true;
        } else {
            $create_records = false;
        }

        $customers_list = Customer::orderBy('name')->pluck('name', 'id');
        $customers_list->prepend('', '');

        $table_height = Auth::user()->table_height;

        return view('dataFeed/sambaupload', compact('messages_only_errors', 'messages', 'color', 'create_records', 'customers_list', 'users_select', 'ids', 'table_height'));
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

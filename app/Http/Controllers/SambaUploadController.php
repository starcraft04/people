<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\SambaUploadRequest;
use App\Repositories\ActivityRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use App\SambaName;
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
          'msg'=>'LINE '.$i.': Found '.count($projectInDB).' instance of Samba ID:'.$row['public_opportunity_id'], ]);
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
            'public_opportunity_id' => $row['public_opportunity_id'],
            'opportunity_name' => $row['opportunity_name'],
            'opportunity_owner' => $row['opportunity_owner'],
            'created_date' => $row['created_date'],
            'close_date' => $row['close_date'],
            'stage' => $row['stage'],
            'probability' => $row['probability'],
            'amount_tcv' => $row['amount_tcv_converted'],
            'consulting_tcv' => $consulting_tcv,
            'in_db' => $in_db,
            'color' => $color,
          ]);
                }
            }
            //dd($ids);
            foreach ($ids as &$row) {
                if ($row['in_db']) {
                    $projectInDB = $this->projectRepository->getBySambaID($row['public_opportunity_id']);
                    foreach ($projectInDB as $key => $project) {
                        $customer = $project->customer()->first();
                        //dd($row['probability']);
                        array_push($messages, ['status'=>'update',
            'msg'=>'LINE '.$i.': '.
                ' <b>Customer</b>: <u>'.$customer->name.'</u> / <b>Opportunity</b>: <u>'.$project->project_name.'</u> / <b>Samba ID</b>: <u>'.$row['public_opportunity_id'].'</u>'.' -> project updated in the DB.', ]);
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
                    }
                } else {
                    $name = SambaName::where('samba_name', $row['account_name'])->first();
                    if ($name != null) {
                        $row['account_name_modified'] = $name->dolphin_name;
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

    public function postFormCreate(Request $request)
    {

    // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
        $result = new \stdClass();
        $result->result = 'success';
        $result->msg = 'Records added successfully';

        $inputs = $request->all();
        $year = $inputs['year'];
        $datas = json_decode($inputs['data']);
        //dd($datas);
        // datas is in the following form:
        /* array:2 [
          0 => {
            +"samba_lead_domain": "Security"
            +"customer_samba": "GlaxoSmithKline plc"
            +"customer_dolphin": "70"
            +"project_name": "GSK USB Scanning Device"
            +"assigned_user": "9"
            +"samba_id": "70165805"
            +"order_intake": "540990"
            +"opportunity_owner": "Mike Christodoulou"
            +"creat_date": "2018-12-13"
            +"close_date": "2019-10-25"
            +"samba_stage": "2 Qualification"
            +"win_ratio": "10"
          }
          1 => {...
          }
        ] */

        // Now we will loop through the datas
        // First we need to check if the projects already exists

        //dd($datas);

        foreach ($datas as $key => $data) {
            // Let's look if we need to update the database for the relation between the samba names and dolphin names
            $name = SambaName::where('samba_name', $data->customer_samba)->first();
            if ($name == null) {
                $dolphin_name = Customer::find($data->customer_dolphin);
                $name = new SambaName;
                $name->samba_name = $data->customer_samba;
                $name->dolphin_name = $dolphin_name->name;
                $name->save();
            }

            // Let's assign the right column names
            $project_inputs = [];
            $project_inputs['samba_lead_domain'] = trim($data->samba_lead_domain);
            $project_inputs['customer_id'] = $data->customer_dolphin;
            $project_inputs['project_name'] = trim($data->project_name);
            $project_inputs['samba_id'] = trim($data->samba_id);
            $project_inputs['revenue'] = $data->order_intake;
            if ($data->consulting_tcv != '') {
                $project_inputs['samba_consulting_product_tcv'] = $data->consulting_tcv;
            }
            $project_inputs['samba_opportunit_owner'] = trim($data->opportunity_owner);
            $project_inputs['estimated_start_date'] = $data->create_date;
            $project_inputs['estimated_end_date'] = $data->close_date;
            $project_inputs['samba_stage'] = trim($data->samba_stage);
            $project_inputs['win_ratio'] = $data->win_ratio;
            $project_inputs['meta_activity'] = null;
            $project_inputs['otl_project_code'] = null;
            $project_inputs['project_type'] = 'Pre-sales';

            // Let's check if we can find in the DB a record with the same project name and customer id
            $project_count = $this->projectRepository->getByNameCustomernum($project_inputs['project_name'], $project_inputs['customer_id']);
            if ($project_count > 0) {
                $project = $this->projectRepository->getByNameCustomer($project_inputs['project_name'], $project_inputs['customer_id']);
                $project_inputs_update['samba_lead_domain'] = $project_inputs['samba_lead_domain'];
                $project_inputs_update['samba_id'] = $project_inputs['samba_id'];
                $project_inputs_update['revenue'] = $project_inputs['revenue'];
                if ($data->consulting_tcv != '') {
                    $project_inputs_update['samba_consulting_product_tcv'] = $project_inputs['samba_consulting_product_tcv'];
                }
                $project_inputs_update['samba_opportunit_owner'] = $project_inputs['samba_opportunit_owner'];
                $project_inputs_update['estimated_start_date'] = $project_inputs['estimated_start_date'];
                $project_inputs_update['estimated_end_date'] = $project_inputs['estimated_end_date'];
                $project_inputs_update['samba_stage'] = $project_inputs['samba_stage'];
                $project_inputs_update['win_ratio'] = $project_inputs['win_ratio'];
                $project = $this->projectRepository->update($project->id, $project_inputs_update);
            } else {
                $project = $this->projectRepository->create($project_inputs);
            }
            // Now we need to assign the user
            $activity_inputs['year'] = $year;
            $activity_inputs['month'] = 1;
            $activity_inputs['project_id'] = $project->id;
            $activity_inputs['user_id'] = $data->assigned_user;
            $activity_inputs['task_hour'] = 0;

            // Let's check if we can find in the DB a record with the same activity
            $activity_count = $this->activityRepository->getByYMPUnum($activity_inputs['year'], $activity_inputs['month'], $activity_inputs['project_id'], $activity_inputs['user_id']);
            if ($activity_count > 0) {
            } else {
                $activity = $this->activityRepository->create($activity_inputs);
            }
        }

        return json_encode($result);
    }
}

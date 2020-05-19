<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\OtlUploadRequest;
use App\Repositories\ActivityRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportExcelToArray;

class OtlUploadController extends Controller
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
        return view('dataFeed/otlupload');
    }

    public function help()
    {
        return view('dataFeed/otlupload_help');
    }

    public function postForm(OtlUploadRequest $request)
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

        // now we will need a association between months written in letters and numbers because in the activites table it is in numbers and in the excel file it is in letters
        $months_converted = [
            'jan' => 1,
            'feb' => 2,
            'mar' => 3,
            'apr' => 4,
            'may' => 5,
            'jun' => 6,
            'jul' => 7,
            'aug' => 8,
            'sep' => 9,
            'oct' => 10,
            'nov' => 11,
            'dec' => 12,
        ];

        $months_prime = [
            1 => 'jan',
            2 => 'feb',
            3 => 'mar',
            4 => 'apr',
            5 => 'may',
            6 => 'jun',
            7 => 'jul',
            8 => 'aug',
            9 => 'sep',
            10 => 'oct',
            11 => 'nov',
            12 => 'dec',
        ];

        //First we need to get all employees for this manager
        $all_users = $this->userRepository->getAllUsersFromManager(Auth::user()->id);
        // Then we extract only the ids of the users reporting to the auth user
        $users_id = [];
        foreach ($all_users as $key => $user) {
            array_push($users_id, $user['id']);
        }
        //dd($users_id);

        $file = $request->file('uploadfile');
        if ($file->isValid()) {
            // In case we send a CSV file, the worksheet name is : Worksheet
            $reader = new ImportExcelToArray();
            $reader->startingRow = 1;
            $temp = Excel::import($reader,$file);
            $result = $reader->sheetData['Worksheet'];

            $columns_needed_PRIME = ['project_name', 'billable_task', 'name', 'year', 'month', 'time_entered_in_days'];

            //dd($reader->sheetData);
            //dd($reader->checkMinHeaders('Worksheet',$columns_needed_PRIME));

            // If the columns are not all present then we have an error and go back
            if ($reader->checkMinHeaders('Worksheet',$columns_needed_PRIME)) {
                // First thing we need to do is to go over each line and sum the column time entered in days for each
                // Row with the same column project_name, billable_task, name, year and month
                $header_already_used = [];
                $new_result = [];
                foreach ($result as $r) {
                    $composite = $r['project_name'].'_'.$r['billable_task'].'_'.$r['name'].'_'.$r['year'].'_'.$r['month'];
                    if (in_array($composite, $header_already_used)) {
                        continue;
                    } else {
                        array_push($header_already_used, $composite);
                        $value = [];
                        $value['customer_name'] = '?';
                        $value['project_name'] = $r['project_name'];
                        if ($r['billable_task'] == 'Y') {
                            $value['meta_activity'] = 'BILLABLE';
                        } else {
                            $value['meta_activity'] = 'OTHER';
                        }
                        $value['employee_name'] = str_replace(', ', ',', $r['name']);
                        $value['year'] = intval($r['year']);
                        $value['month'] = $months_prime[intval($r['month'])];

                        $var1 = $r['project_name'];
                        $var2 = $r['billable_task'];
                        $var3 = $r['name'];
                        $var4 = $r['year'];
                        $var5 = $r['month'];
                        $filtered_array = array_filter($result, function ($val) use ($var1, $var2, $var3, $var4, $var5) {
                            return $val['project_name'] == $var1 and $val['billable_task'] == $var2 and $val['name'] == $var3 and $val['year'] == $var4 and $val['month'] == $var5;
                        });
                        /* if ($r["month"] == '9') {
                          dd($filtered_array);
                        } */
                        $value['converted_time'] = 0;
                        foreach ($filtered_array as $row) {
                            $value['converted_time'] += floatval(str_replace(',', '.', $row['time_entered_in_days']));
                        }
                        $value['unit'] = 'days';
                        array_push($new_result, $value);
                    }
                }
                $result = $new_result;

            //dd($result);
            } else {
                array_push($messages, ['status'=>'error',
                'user' =>'',
                'msg'=>'Some columns are required but not present in the file, please see the sample file and upload again.', ]);

                return view('dataFeed/otlupload', compact('messages', 'color'));
            }

            foreach ($result as $row) {
                $userInDB = $this->userRepository->getByName($row['employee_name']);
                $projectInDBnum = $this->projectRepository->getByOTLnum($row['project_name'], $row['meta_activity']);

                // Checking if the user is in DB
                if (empty($userInDB)) {
                    if (! in_array(['status'=>'error', 'msg'=>'User is not in DB', 'user' =>$row['employee_name']], $messages, true)) {
                        array_push($messages, ['status'=>'error',
                            'msg'=>'User is not in DB',
                            'user' =>$row['employee_name'],
                        ]);
                    }
                    continue;
                }
                // END check user

                // Checking if you have the rights to modify this user
                if (! Auth::user()->can('otl-upload-all') && ! in_array($userInDB->id, $users_id)) {
                    if (! in_array(['status'=>'error', 'msg'=>'User not your employee', 'user' =>$row['employee_name']], $messages, true)) {
                        array_push($messages, ['status'=>'error',
            'msg'=>'User not your employee',
            'user' =>$row['employee_name'],
            ]);
                    }
                    continue;
                }

                if (! array_key_exists(strtolower($row['month']), $months_converted)) {
                    if (! in_array(['status'=>'error', 'user' =>'', 'msg'=>'Month '.$row['month'].' is not a correct value, it should be in the form Jan, Feb, Mar, ...'], $messages, true)) {
                        array_push($messages, ['status'=>'error',
            'user' =>'',
            'msg'=> 'Month '.$row['month'].' is not a correct value, it should be in the form Jan, Feb, Mar, ...',
            ]);
                    }
                    continue;
                }

                if ($row['converted_time'] == 0) {
                    continue;
                }

                if ($row['unit'] != 'days') {
                    continue;
                }

                //dd($projectInDBnum);

                // Checking if the project is in DB
                if ($projectInDBnum != 1) {
                    if (! in_array(['status'=>'error', 'mgr'=>$userInDB->managers->first()->name, 'msg'=>'this Prime code and META activity is not found in the DB.', 'user' =>$row['employee_name'], 'customer_prime' => $row['customer_name'], 'prime_code' => $row['project_name'], 'meta' => $row['meta_activity'], 'year' => $row['year']], $messages, true)) {
                        array_push($messages, ['status'=>'error',
              'mgr'=>$userInDB->managers->first()->name,
              'msg'=>'this Prime code and META activity is not found in the DB.',
              'user' =>$row['employee_name'],
              'customer_prime' => $row['customer_name'],
              'prime_code' => $row['project_name'],
              'meta' => $row['meta_activity'],
              'year' => $row['year'],
              ]);
                    }
                    continue;
                } else {
                    // Only if we can find 1 instance of a mix of otl_project_code and meta-activity then we enter the activity
                    $projectInDB = $this->projectRepository->getByOTL($row['project_name'], $row['meta_activity']);
                    // Now we can check if we find a customer link ID in the Prime code, it should be in the form IB-PP-...
                    // For that we will use a regex that can be found in the config/option.php
                    // $matches will contain in [0] the whole matching expression and [1] will be the first () in the regexp
                    if (preg_match(config('options.regex_for_prime_cl'), $row['project_name'], $matches)) {
                        // We need to check first that the customer link id in the project is empty
                        if (empty($projectInDB->samba_id)) {
                            $projectInDB->samba_id = $matches[1];
                        }
                    }
                    $projectInDB->otl_validated = 1;
                    $projectInDB->save();
                }
                // END check project

                // If User AND Project is found in DB then we can update the activities
                $activity = [];
                // Now we need to check if we need to update or create an activity
                $activity['year'] = $row['year'];
                // We need to check first that a month has well been entered

                $activity['month'] = $months_converted[strtolower($row['month'])];
                $activity['user_id'] = $userInDB->id;
                $activity['project_id'] = $projectInDB->id;
                $activity['task_hour'] = $row['converted_time'];
                $activity['from_otl'] = 1;
                $activityInDB = $this->activityRepository->checkIfExists($activity);
                if (! $activityInDB) {
                    $this->activityRepository->create($activity);
                } else {
                    $this->activityRepository->update($activityInDB->id, $activity);
                }
                // END assign activities
            }
        }

        $customers_list = Customer::orderBy('name')->pluck('name', 'id');

        array_multisort(array_column($messages, 'user'), SORT_ASC, $messages);
        \Session::flash('success', 'File uploaded');

        return view('dataFeed/otlupload', compact('messages', 'color', 'customers_list'));
    }
}

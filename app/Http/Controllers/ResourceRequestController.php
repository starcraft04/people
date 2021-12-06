<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Action;
use App\Activity;
use App\Comment;
use App\Customer;
use App\ResourceRequest;
use App\Http\Controllers\Auth\AuthUsersForDataView;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\ProjectRevenue;
use App\Repositories\ActivityRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use App\Skill;
use App\User;
use App\UserSkill;
use Auth;
use Datatables;
use DB;
use Illuminate\Http\Request;
use Session;

class ResourceRequestController extends Controller
{
    //
    protected $userRepository;
    protected $projectRepository;

    public function __construct(UserRepository $userRepository, ProjectRepository $projectRepository)
    {
        $this->userRepository = $userRepository;
        $this->projectRepository = $projectRepository;
    }

    public function viewRequests(AuthUsersForDataView $authUsersForDataView){
        $authUsersForDataView->userCanView('tools-activity-all-view');
        Session::put('url', 'toolsActivities');
        $table_height = Auth::user()->table_height;

        $customers_list = Customer::orderBy('name')->pluck('name', 'id');
        

        return view("resourcesRequest/list",compact('authUsersForDataView', 'table_height','customers_list'));
    }

    public function create_request(Request $request)
    {
        // code...
         $validator = \Validator::make($request->all(), [
            'budget' => 'required',
            'currecny' => 'required',
            'duration' =>'required',
            'revenue'=>'required',
            'cost'=>'required',
            'margin'=>'required',
            'internal_check'=>'required',
            'reason_for_request'=>'required',

        ]);
          if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $input = $request->all();


        $record = ResourceRequest::create([
            'Budgeted'=>$input['budget'],
            'consulting_request'=>$input['consulting_request'],
            'PR'=>$input['pr'],
            'PO'=>$input['po'],
            'practice'=>$input['practices'],
            'duration'=>$input['duration'],
            'case_status'=>$input['case_status'],
            'EWR_status '=>$input['ewr_status'],
            'supplier'=>$input['supplier'],
            'contractor_name'=>$input['contractor_name'],
            'revenue'=>$input['revenue'],
            'cost'=>$input['cost'],
            'currency'=>$input['currecny'],
            'margin'=>$input['margin'],
            'internal_check'=>$input['internal_check'],
            'reason_for_request'=>$input['reason_for_request'],
            'description'=>$input['description'],
            'comments'=>$input['comment'],
            'user_id'=>$input['user'],
            'project_id'=>$input['project'],
        ]);
        
        return response()->json(['success'=>'Data is successfully added']);


    }


    public function resource_request_view()
    {
        $requests = DB::table('resources_request');

        $requests->select(
            'resources_request.id',
            'm.name AS manager_name',
            'u.name AS user_name',
            'p.project_name',
            'resources_request.created_at',
            'resources_request.Budgeted',
            'resources_request.consulting_request',
            'resources_request.PR',
            'resources_request.PO',
            'resources_request.practice',
            'resources_request.duration',
            'resources_request.case_status',
            'resources_request.ewr_status',
            'resources_request.supplier',
            'resources_request.revenue',
            'resources_request.cost',
            'resources_request.currency',
            'resources_request.margin',
            'resources_request.internal_check',
            'resources_request.reason_for_request',
            'resources_request.description',
            'resources_request.comments',
            'resources_request.updated_at',
            'resources_request.contractor_name',
            'resources_request.date_of_complete');
        $requests->leftjoin('projects AS p', 'p.id', '=', 'resources_request.project_id');
        $requests->leftjoin('project_loe AS loe', 'resources_request.project_id', '=', 'loe.project_id');
        $requests->leftjoin('users AS u', 'resources_request.user_id', '=', 'u.id');
        $requests->leftjoin('users_users AS uu', 'u.id', '=', 'uu.user_id');
        $requests->leftjoin('users AS m', 'm.id', '=', 'uu.manager_id');
        $requests->leftjoin('customers AS c', 'c.id', '=', 'p.customer_id');

        $dataRequests = $requests->get();

        $data = Datatables::of($requests)->make(true);

        unset($requests);


        return $data;
    }


    public function requestDelete($id)
    {
        // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
        $result = new \stdClass();

        

        $request = ResourceRequest::find($id);

        ResourceRequest::destroy($id);

        $result->result = 'success';
        $result->msg = 'Record deleted successfully';

        return json_encode($result);
    }

    public function getRequest($id)
    {
        $resource = ResourceRequest::where('id',$id)->get();

        return json_encode($resource);
    }

    public function updateRequest($id,Request $request)
    {


        $result = new \stdClass();

        $input = $request->all();

        if($input['case_status'] == 1){
            $Curr_date = date('Y-m-d H:i:s');
        $updated = [
            'Budgeted'=>$input['budget'],
            'consulting_request'=>$input['consulting_request'],
            'PR'=>$input['pr'],
            'PO'=>$input['po'],
            'practice'=>$input['practices'],
            'duration'=>$input['duration'],
            'case_status'=>$input['case_status'],
            'EWR_status'=>$input['ewr_status'],
            'supplier'=>$input['supplier'],
            'contractor_name'=>$input['contractor_name'],
            'revenue'=>$input['revenue'],
            'cost'=>$input['cost'],
            'currency'=>$input['currecny'],
            'margin'=>$input['margin'],
            'internal_check'=>$input['internal_check'],
            'reason_for_request'=>$input['reason_for_request'],
            'description'=>$input['description'],
            'comments'=>$input['comment'],
            'date_of_complete'=>$Curr_date,
        ];
    }
    else{
        $updated = [
            'Budgeted'=>$input['budget'],
            'consulting_request'=>$input['consulting_request'],
            'PR'=>$input['pr'],
            'PO'=>$input['po'],
            'practice'=>$input['practices'],
            'duration'=>$input['duration'],
            'case_status'=>$input['case_status'],
            'EWR_status'=>$input['ewr_status'],
            'supplier'=>$input['supplier'],
            'contractor_name'=>$input['contractor_name'],
            'revenue'=>$input['revenue'],
            'cost'=>$input['cost'],
            'currency'=>$input['currecny'],
            'margin'=>$input['margin'],
            'internal_check'=>$input['internal_check'],
            'reason_for_request'=>$input['reason_for_request'],
            'description'=>$input['description'],
            'comments'=>$input['comment'],
        ];

    }
        $updateField = ResourceRequest::where('id',$id)->update($updated);

        $resource = ResourceRequest::where('id',$id)->get();
        
        $result->result = 'success';
        $result->msg = 'Record Updated successfully';

        return json_encode($result);
    }




}



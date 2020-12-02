<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Requests\ProjectRevenueCreateRequest;
use App\Http\Requests\ProjectRevenueUpdateRequest;
use App\Project;
use App\ProjectRevenue;
use App\Repositories\ProjectRepository;
use Auth;
use Datatables;
use DB;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getList()
    {
        return view('project/list');
    }

    public function show($id)
    {
        $project = $this->projectRepository->getById($id);
        $customer = $this->projectRepository->getProjectCustomer($id);

        return view('project/show', compact('project', 'customer'));
    }

    public function getFormCreate()
    {
        $today = date('Y-m-d');
        $customers_list = Customer::orderBy('name')->pluck('name', 'id');
        $customers_list->prepend('', '');

        return view('project/create_update', compact('today', 'customers_list'))->with('action', 'create');
    }

    public function getFormUpdate($id)
    {
        $project = $this->projectRepository->getById($id);
        $customers_list = Customer::orderBy('name')->pluck('name', 'id');
        $customers_list->prepend('', '');

        return view('project/create_update', compact('project', 'customers_list'))->with('action', 'update');
    }

    public function postFormCreate(ProjectCreateRequest $request)
    {
        $inputs = $request->all();
        $project = $this->projectRepository->create($inputs);

        return redirect('projectList')->with('success', 'Record created successfully');
    }

    public function postFormUpdate(ProjectUpdateRequest $request, $id)
    {
        $inputs = $request->all();
        $project = $this->projectRepository->update($id, $inputs);

        return redirect('projectList')->with('success', 'Record updated successfully');
    }

    public function delete($id)
    {
        // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
        $result = new \stdClass();

        if (count(Project::find($id)->activities) > 0) {
            $result->result = 'error';
            $result->msg = 'Record cannot be deleted because some activities are associated to it.';

            return json_encode($result);
        } else {
            $customer = Project::destroy($id);
            $result->result = 'success';
            $result->msg = 'Record deleted successfully';

            return json_encode($result);
        }
    }

    public function listOfProjectsRevenue($id)
    {
        $project_revenues = Project::findOrFail($id)->revenues();
        $data = Datatables::of($project_revenues)->make(true);

        return $data;
    }


    public function addRevenue(ProjectRevenueCreateRequest $request)
    {
        // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
        $result = new \stdClass();
        $inputs = $request->all();

        ProjectRevenue::create($inputs);

        $result->result = 'success';
        $result->msg = 'Record added successfully';

        return json_encode($result);
    }

    public function updateRevenue(ProjectRevenueUpdateRequest $request,$id)
    {
        // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
        $result = new \stdClass();
        $inputs = $request->all();
        $projectRevenueToUpdate = ProjectRevenue::find($id);
        $projectRevenueToUpdate->update($inputs);
        $result->result = 'success';
        $result->msg = 'Record updated successfully';

        return json_encode($result);
    }

    public function deleteRevenue($id)
    {
        // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
        $result = new \stdClass();
        $customer = ProjectRevenue::destroy($id);
        $result->result = 'success';
        $result->msg = 'Record deleted successfully';

        return json_encode($result);
    }

    public function listOfprojects(Request $request)
    {
        $inputs = $request->all();

        $projectList = Project::select('projects.id','customers.name AS customer_name','project_name','otl_project_code','project_type','activity_type','project_status','meta_activity','region',
                        'country','technology','description','estimated_start_date','estimated_end_date','comments','LoE_onshore','LoE_nearshore',
                        'LoE_offshore', 'LoE_contractor', 'gold_order_number', 'product_code', 'revenue', 'win_ratio')
            ->leftjoin('customers', 'projects.customer_id', '=', 'customers.id');

        if (isset($inputs['unassigned']) && $inputs['unassigned'] == 'true') {
            $projectList->doesntHave('activities');
        } elseif (isset($inputs['unassigned']) && $inputs['unassigned'] == 'false') {
            $projectList->has('activities');
        }

        $data = Datatables::of($projectList)->make(true);

        return $data;
    }

    public function listOfProjectsMissingInfo(Request $request)
    {
        $inputs = $request->all();

        return $this->projectRepository->getListOfProjectsMissingInfo($inputs);
    }

    public function listOfProjectsMissingOTL(Request $request)
    {
        $inputs = $request->all();

        return $this->projectRepository->getListOfProjectsMissingOTL($inputs);
    }

    public function listOfProjectsLost(Request $request)
    {
        $inputs = $request->all();

        return $this->projectRepository->getListOfProjectsLost($inputs);
    }

    public function listOfProjectsAll()
    {
        $projectList = Project::select('projects.id','customers.name AS customer_name','projects.project_name','projects.otl_project_code','projects.project_type',
                    'projects.activity_type','projects.project_status','projects.meta_activity','projects.region',
                    'projects.country','projects.technology','projects.description','projects.estimated_start_date','projects.estimated_end_date',
                    'projects.comments','projects.LoE_onshore','projects.LoE_nearshore','projects.samba_id',
                    'projects.LoE_offshore', 'projects.LoE_contractor', 'projects.gold_order_number', 'projects.product_code', 'projects.revenue', 'projects.win_ratio');
        $projectList->leftjoin('customers', 'projects.customer_id', '=', 'customers.id');

        $data = Datatables::of($projectList)->make(true);
  
        return $data;
    }

    public function listOfProjectsNotUsedInPrime($user_name, $year)
    {
        $projects = DB::table('projects')
            ->select(
                'customers.name AS customer_name',
                'projects.id AS project_id',
                'projects.project_name AS project_name',
                'projects.project_type AS project_type',
                'projects.project_status AS project_status',
                'projects.otl_project_code AS prime_code',
                'projects.meta_activity AS meta_activity'
            )
            ->leftjoin('customers', 'projects.customer_id', '=', 'customers.id')
            ->leftjoin('activities', 'activities.project_id', '=', 'projects.id')
            ->leftjoin('users', 'users.id', '=', 'activities.user_id')
            ->where('users.name', '=', $user_name)
            ->where('activities.year', '=', $year)
            ->groupBy('project_id')
            ->orderBy('customer_name')
            ->where('projects.otl_validated', '=', 0)
            ->get();

        return $projects;
    }

    public function listOfProjectsNotUsedInCL($year, $user_id = null)
    {
        $projects = DB::table('projects')
            ->select(
                'customers.name AS customer_name',
                'projects.id AS project_id',
                'projects.project_name AS project_name',
                'projects.project_type AS project_type',
                'projects.project_status AS project_status',
                'u.name AS user_name',
                'projects.samba_id AS samba_id'
            )
            ->leftjoin('customers', 'projects.customer_id', '=', 'customers.id')
            ->leftjoin('activities', 'activities.project_id', '=', 'projects.id')
            ->leftjoin('users AS u', 'activities.user_id', '=', 'u.id')
            ->leftjoin('users_users AS uu', 'u.id', '=', 'uu.user_id')
            ->leftjoin('users AS m', 'm.id', '=', 'uu.manager_id')
            ->where('activities.year', '=', $year)
            ->where('m.id',Auth::user()->id)
            ->where('project_type','Pre-sales')
            ->where('customers.name','!=','Orange Business Services')
            ->whereNull('samba_id');
        if ($user_id != null) {
            $projects->where('u.id',$user_id);
        }
        $projects->groupBy('project_id');


        $data = Datatables::of($projects)->make(true);

    

        return $data;
    }

    public function createProjectFromPrimeUpload(Request $request)
    {
        $inputs = $request->all();
        $project_check = Project::where('project_name', $inputs['project_name'])->where('customer_id', $inputs['customer_id'])
            ->get()
            ->count();
        $prime_check = Project::where('otl_project_code', $inputs['prime_code'])->where('meta_activity', $inputs['meta'])
            ->get()
            ->count();
        // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
        $result = new \stdClass();
        if ($project_check == 0) {
            if ($prime_check == 0) {
                $project = new Project;
                $project->project_name = $inputs['project_name'];
                $project->customer_id = $inputs['customer_id'];
                $project->project_type = $inputs['project_type'];
                $project->project_status = $inputs['project_status'];
                $project->otl_project_code = $inputs['prime_code'];
                $project->meta_activity = $inputs['meta'];
                $project->save();
                $result->result = 'success';
                $result->msg = 'Record added successfully';

                return json_encode($result);
            } else {
                $result->result = 'error';
                $result->msg = 'This prime code and meta activity already exist in the database';

                return json_encode($result);
            }
        } else {
            $result->result = 'error';
            $result->msg = 'This project name and customer name already exist in the database';

            return json_encode($result);
        }
    }

    public function editProjectFromPrimeUpload(Request $request)
    {
        $inputs = $request->all();
        // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
        $result = new \stdClass();
        $project = Project::find($inputs['project_id']);
        if ($project->otl_validated == 0) {
            $project->otl_project_code = $inputs['prime_code'];
            $project->meta_activity = $inputs['meta'];
            $project->save();
            $result->result = 'success';
            $result->msg = 'Record modified successfully';

            return json_encode($result);
        } else {
            $result->result = 'error';
            $result->msg = 'You don\'t have the rights to modify this record';

            return json_encode($result);
        }
    }
}

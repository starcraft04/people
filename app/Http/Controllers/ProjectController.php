<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Loe;
use App\Project;
use App\ProjectRevenue;
use App\Repositories\ProjectRepository;
use App\Role;
use Auth;
use Datatables;
use DB;
use Entrust;
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
        $customers_list = Customer::orderBy('name')->lists('name', 'id');
        $customers_list->prepend('', '');

        return view('project/create_update', compact('today', 'customers_list'))->with('action', 'create');
    }

    public function getFormUpdate($id)
    {
        $project = $this->projectRepository->getById($id);
        $customers_list = Customer::orderBy('name')->lists('name', 'id');
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

    public function addRevenue(Request $request)
    {
        // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
        $result = new \stdClass();
        $inputs = $request->all();
        $projectRevenue = ProjectRevenue::where('project_id', '=', $inputs['project_id'])->where('year', '=', $inputs['year'])->where('product_code', '=', $inputs['product_code'])->first();
        if ($projectRevenue === null) {
            DB::table('project_revenues')->insert($inputs);
            $result->result = 'success';
            $result->msg = 'Record added successfully';
        } else {
            $result->result = 'error';
            $result->msg = 'Record already in DB';
        }

        return json_encode($result);
    }

    public function updateRevenue(Request $request)
    {
        // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
        $result = new \stdClass();
        $inputs = $request->all();
        $projectRevenueToUpdate = ProjectRevenue::find($inputs['id']);
        if ($inputs['column_name'] == 'year') {
            $projectRevenue = ProjectRevenue::where('project_id', '=', $projectRevenueToUpdate->project_id)->where('year', '=', $inputs['value'])->where('product_code', '=', $projectRevenueToUpdate->product_code)->first();
        } elseif ($inputs['column_name'] == 'product_code') {
            $projectRevenue = ProjectRevenue::where('project_id', '=', $projectRevenueToUpdate->project_id)->where('year', '=', $projectRevenueToUpdate->year)->where('product_code', '=', $inputs['value'])->first();
        } else {
            $projectRevenue = null;
        }

        if ($projectRevenue === null) {
            $projectRevenueToUpdate->{$inputs['column_name']} = $inputs['value'];
            $projectRevenueToUpdate->save();
            $result->result = 'success';
            $result->msg = 'Record updated successfully';
        } else {
            $result->result = 'error';
            $result->msg = 'Record already in DB';
        }

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

        return $this->projectRepository->getListOfProjects($inputs);
    }

    public function listOfProjectsRevenue($id)
    {
        $project_revenues = Project::findOrFail($id)->revenues();

        if (Auth::user()->can('projectRevenue-edit')) {
            $data = Datatables::of($project_revenues)
            ->editColumn('year', '<div contenteditable class="rev_update" data-id="{{$id}}" data-column="year">{{$year}}</div>')
            ->editColumn('product_code', '<div contenteditable class="rev_update" data-id="{{$id}}" data-column="product_code">{{$product_code}}</div>')
            ->editColumn('jan', '<div contenteditable class="rev_update" data-id="{{$id}}" data-column="jan">{{$jan}}</div>')
            ->editColumn('feb', '<div contenteditable class="rev_update" data-id="{{$id}}" data-column="feb">{{$feb}}</div>')
            ->editColumn('mar', '<div contenteditable class="rev_update" data-id="{{$id}}" data-column="mar">{{$mar}}</div>')
            ->editColumn('apr', '<div contenteditable class="rev_update" data-id="{{$id}}" data-column="apr">{{$apr}}</div>')
            ->editColumn('may', '<div contenteditable class="rev_update" data-id="{{$id}}" data-column="may">{{$may}}</div>')
            ->editColumn('jun', '<div contenteditable class="rev_update" data-id="{{$id}}" data-column="jun">{{$jun}}</div>')
            ->editColumn('jul', '<div contenteditable class="rev_update" data-id="{{$id}}" data-column="jul">{{$jul}}</div>')
            ->editColumn('aug', '<div contenteditable class="rev_update" data-id="{{$id}}" data-column="aug">{{$aug}}</div>')
            ->editColumn('sep', '<div contenteditable class="rev_update" data-id="{{$id}}" data-column="sep">{{$sep}}</div>')
            ->editColumn('oct', '<div contenteditable class="rev_update" data-id="{{$id}}" data-column="oct">{{$oct}}</div>')
            ->editColumn('nov', '<div contenteditable class="rev_update" data-id="{{$id}}" data-column="nov">{{$nov}}</div>')
            ->editColumn('dec', '<div contenteditable class="rev_update" data-id="{{$id}}" data-column="dec">{{$dec}}</div>')
            ->make(true);
        } else {
            $data = Datatables::of($project_revenues)->make(true);
        }

        return $data;
    }

    public function listOfProjectsLoe($id)
    {
        $project_loes = DB::table('project_loe')
      ->leftjoin('projects', 'projects.id', '=', 'project_loe.project_id')
      ->leftjoin('customers', 'customers.id', '=', 'projects.customer_id')
      ->leftjoin('users', 'users.id', '=', 'project_loe.user_id')
      ->select('project_loe.id AS loe_id','project_loe.project_id AS p_id','projects.project_name','customers.name AS customer_name','users.name AS user_name','project_loe.start_date',
                'project_loe.end_date','project_loe.domain','project_loe.type','project_loe.location','project_loe.mandays','project_loe.description','project_loe.history','project_loe.signoff',
                'project_loe.created_at', 'project_loe.updated_at')
      ->where('project_id', $id);

        $data = Datatables::of($project_loes)->make(true);

        return $data;
    }

    public function listOfAllProjectsLoe($year)
    {
        $project_loes = DB::table('project_loe')
      ->leftjoin('projects', 'projects.id', '=', 'project_loe.project_id')
      ->leftjoin('customers', 'customers.id', '=', 'projects.customer_id')
      ->leftjoin('users', 'users.id', '=', 'project_loe.user_id')
      ->leftjoin('users_users AS uu', 'users.id', '=', 'uu.user_id')
      ->leftjoin('users AS m', 'm.id', '=', 'uu.manager_id')
      ->select('project_loe.id AS loe_id','project_loe.project_id AS p_id','projects.project_name','customers.name AS customer_name','users.name AS user_name','project_loe.start_date',
                'project_loe.end_date','project_loe.domain','project_loe.type','project_loe.location','project_loe.mandays','project_loe.description','project_loe.history','project_loe.signoff',
                'project_loe.created_at', 'project_loe.updated_at', 'projects.samba_id', 'customers.cluster_owner', 'm.name AS manager_name')
      ->where('project_loe.created_at', 'like', '%'.$year.'%');

        $data = Datatables::of($project_loes)->make(true);

        return $data;
    }

    public function deleteLoe($id)
    {
        // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
        $result = new \stdClass();
        $loe_result = Loe::find($id);
        if ($loe_result->user_id == Auth::user()->id || Entrust::can('projectLoe-deleteAll')) {
            $loe_result->delete();
            $result->result = 'success';
            $result->box_type = 'success';
            $result->message_type = 'success';
            $result->msg = 'Record deleted successfully';
        } else {
            $result->result = 'error';
            $result->box_type = 'danger';
            $result->message_type = 'error';
            $result->msg = 'No permission to delete record';
        }

        return json_encode($result);
    }

    public function addLoe(Request $request)
    {
        // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
        $result = new \stdClass();
        $inputs = $request->all();
        $Loe = new Loe;
        $startdate = explode(' - ', $inputs['date'])[0];
        $enddate = explode(' - ', $inputs['date'])[1];
        if (Auth::user()->is_manager == 1) {
            $signoff = 1;
        } else {
            $signoff = 0;
        }

        $Loe->project_id = $inputs['project_id'];
        $Loe->user_id = Auth::user()->id;
        $Loe->start_date = $startdate;
        $Loe->end_date = $enddate;
        $Loe->domain = $inputs['domain'];
        $Loe->type = $inputs['type'];
        $Loe->location = $inputs['location'];
        $Loe->mandays = $inputs['mandays'];
        $Loe->description = $inputs['description'];
        $Loe->signoff = $signoff;

        $Loe->save();

        $result->result = 'success';
        $result->msg = 'Record added successfully';

        return json_encode($result);
    }

    public function updateLoe(Request $request)
    {
        // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
        $result = new \stdClass();
        $inputs = $request->all();
        $today = date('Y-m-d H:i:s');
        $Loe = Loe::find($inputs['loe_id']);

        if ($Loe->user_id == Auth::user()->id || Entrust::can('projectLoe-editAll')) {
            $startdate = explode(' - ', $inputs['date'])[0];
            $enddate = explode(' - ', $inputs['date'])[1];

            if (Auth::user()->is_manager == 1) {
                $signoff = 1;
                $history_signoff = 'Date of change: '.$today.'</BR>-- Changed by: '.Auth::user()->name.'</BR>-- MANAGER SIGNOFF</BR>';
            } else {
                $signoff = 0;
                $history_signoff = '';
            }

            if (! empty($Loe->history)) {
                $history = $Loe->history;
            } else {
                $history = '';
            }
            $Loe->history = $history.'Date of change: '.$today.'</BR>-- Changed by: '.Auth::user()->name.'</BR>-- Mandays: '.$Loe->mandays.' to '.$inputs['mandays'].'</BR>'.$history_signoff;

            $Loe->start_date = $startdate;
            $Loe->end_date = $enddate;
            $Loe->domain = $inputs['domain'];
            $Loe->type = $inputs['type'];
            $Loe->location = $inputs['location'];
            $Loe->mandays = $inputs['mandays'];
            $Loe->description = $inputs['description'];
            $Loe->signoff = $signoff;

            $Loe->save();

            $result->result = 'success';
            $result->box_type = 'success';
            $result->message_type = 'success';
            $result->msg = 'Record edited successfully';
        } else {
            $result->result = 'error';
            $result->box_type = 'danger';
            $result->message_type = 'error';
            $result->msg = 'No permission to edit record';
        }

        return json_encode($result);
    }

    public function listOfProjectsLoeSignoff($loe_id)
    {
        // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
        $result = new \stdClass();
        $today = date('Y-m-d H:i:s');
        $Loe = Loe::find($loe_id);

        if (($Loe->user_id == Auth::user()->id || Entrust::can('projectLoe-editAll')) && Entrust::can('projectLoe-signoff')) {
            if (! empty($Loe->history)) {
                $history = $Loe->history;
            } else {
                $history = '';
            }
            if ($Loe->signoff == 0) {
                $Loe->signoff = 1;
                $Loe->history = $history.'Date of change: '.$today.'</BR>-- Changed by: '.Auth::user()->name.'</BR>-- MANAGER SIGNOFF</BR>';
            } else {
                $Loe->signoff = 0;
                $Loe->history = $history.'Date of change: '.$today.'</BR>-- Changed by: '.Auth::user()->name.'</BR>-- MANAGER  REMOVED SIGNOFF</BR>';
            }
            $Loe->save();

            $result->result = 'success';
            $result->box_type = 'success';
            $result->message_type = 'success';
            $result->msg = 'Record edited successfully';
        } else {
            $result->result = 'error';
            $result->box_type = 'danger';
            $result->message_type = 'error';
            $result->msg = 'No permission to edit record';
        }

        return json_encode($result);
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

    public function listOfProjectsAll(Request $request)
    {
        $inputs = $request->all();

        return $this->projectRepository->getListOfProjectsAll($inputs);
    }

    public function listOfProjectsNotUsedInPrime($user_name, $year)
    {
        $projects = DB::table('projects')
          ->select('customers.name AS customer_name','projects.id AS project_id','projects.project_name AS project_name',
                    'projects.project_type AS project_type','projects.project_status AS project_status',
                    'projects.otl_project_code AS prime_code', 'projects.meta_activity AS meta_activity')
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

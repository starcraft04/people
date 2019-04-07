<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Activity;
use App\Role;
use App\Repositories\ActivityRepository;
use App\Repositories\UserRepository;
use App\Repositories\ProjectRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityCreateRequest;
use App\Http\Requests\ActivityUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Repositories\ProjectTableRepository;
use DB;
use Entrust;
use Auth;

class ActivityController extends Controller {

  protected $activityRepository;
  protected $userRepository;
  protected $projectRepository;

  public function __construct(ActivityRepository $activityRepository,UserRepository $userRepository,ProjectRepository $projectRepository)
  {
    $this->activityRepository = $activityRepository;
    $this->userRepository = $userRepository;
    $this->projectRepository = $projectRepository;
	}
	public function getList()
	{
		return view('activity/list');
	}

	public function show($id)
	{
    $activity = $this->activityRepository->getById($id);
    $allUsers_list = $this->userRepository->getAllUsersList();
    $allProjects_list = $this->projectRepository->getAllProjectsList();
		return view('activity/show',  compact('activity','allUsers_list','allProjects_list'));
	}

	public function getFormCreate()
	{
    $allUsers_list = $this->userRepository->getAllUsersList();
    $allProjects_list = $this->projectRepository->getAllProjectsList();
		return view('activity/create_update', compact('allUsers_list','allProjects_list'))->with('action','create');
	}

	public function getFormUpdate($id)
	{
    $activity = $this->activityRepository->getById($id);
    $allUsers_list = $this->userRepository->getAllUsersList();
    $allProjects_list = $this->projectRepository->getAllProjectsList();
		return view('activity/create_update', compact('activity','allUsers_list','allProjects_list'))->with('action','update');
	}

  public function postFormCreate(ActivityCreateRequest $request)
	{
    $inputs = $request->all();
    $activity = $this->activityRepository->create($inputs);
    return redirect('activityList')->with('success','Record created successfully');
	}

	public function postFormUpdate(ActivityUpdateRequest $request, $id)
	{
    $inputs = $request->all();
    $activity = $this->activityRepository->update($id, $inputs);
    return redirect('activityList')->with('success','Record updated successfully');
	}

	public function delete($id)
	{
    // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
    $result = new \stdClass();
    $result->result = 'success';
    $result->msg = 'Record deleted successfully';
    $activity = $this->activityRepository->destroy($id);
		return json_encode($result);
	}

  public function ListOfactivities()
  {
    return $this->activityRepository->getListOfActivities();
  }
  public function ListOfactivitiesPerUser(Request $request)
  {
    $input = $request->all();
    return $this->activityRepository->getListOfActivitiesPerUser($input);
  }
  public function listOfLoadPerUserAjax (Request $request)
  {
    $input = $request->all();
    return $this->activityRepository->getlistOfLoadPerUser($input);
  }
  public function listOfLoadPerUserChartAjax (Request $request)
  {
    $inputs = $request->all();

    //$inputs['year'] = ['2017'];
    //$inputs['user'] = [4];

    $theoreticalCapacity = $this->userRepository->getTheoreticalCapacity($inputs);

    $temp_table = new ProjectTableRepository('temp_a');

    $dsc = $this->activityRepository->getListOfLoadPerUserChart('temp_a',$inputs,'project_type != "Pre-sales" and activity_type = "ASC"');
    $isc = $this->activityRepository->getListOfLoadPerUserChart('temp_a',$inputs,'project_type != "Pre-sales" and activity_type = "ISC"');
    $orange = $this->activityRepository->getListOfLoadPerUserChart('temp_a',$inputs,'project_type = "Orange absence or other"');
    $presales = $this->activityRepository->getListOfLoadPerUserChart('temp_a',$inputs,'project_type = "Pre-sales"');

    unset($temp_table);

    $data = [];

    $data ["dscvstotal"] = [];
    $data ["dscvstotal"][0] = new \stdClass();
    $data ["dscvstotal"][0]->year = $inputs['year'][0];
    $data ["dscvstotal"][0]->jan_com = ($dsc[0]->jan_com+$isc[0]->jan_com) != 0 ? 100*($dsc[0]->jan_com)/($dsc[0]->jan_com+$isc[0]->jan_com):0;
    $data ["dscvstotal"][0]->feb_com = ($dsc[0]->feb_com+$isc[0]->feb_com) != 0 ? 100*($dsc[0]->feb_com)/($dsc[0]->feb_com+$isc[0]->feb_com):0;
    $data ["dscvstotal"][0]->mar_com = ($dsc[0]->mar_com+$isc[0]->mar_com) != 0 ? 100*($dsc[0]->mar_com)/($dsc[0]->mar_com+$isc[0]->mar_com):0;
    $data ["dscvstotal"][0]->apr_com = ($dsc[0]->apr_com+$isc[0]->apr_com) != 0 ? 100*($dsc[0]->apr_com)/($dsc[0]->apr_com+$isc[0]->apr_com):0;
    $data ["dscvstotal"][0]->may_com = ($dsc[0]->may_com+$isc[0]->may_com) != 0 ? 100*($dsc[0]->may_com)/($dsc[0]->may_com+$isc[0]->may_com):0;
    $data ["dscvstotal"][0]->jun_com = ($dsc[0]->jun_com+$isc[0]->jun_com) != 0 ? 100*($dsc[0]->jun_com)/($dsc[0]->jun_com+$isc[0]->jun_com):0;
    $data ["dscvstotal"][0]->jul_com = ($dsc[0]->jul_com+$isc[0]->jul_com) != 0 ? 100*($dsc[0]->jul_com)/($dsc[0]->jul_com+$isc[0]->jul_com):0;
    $data ["dscvstotal"][0]->aug_com = ($dsc[0]->aug_com+$isc[0]->aug_com) != 0 ? 100*($dsc[0]->aug_com)/($dsc[0]->aug_com+$isc[0]->aug_com):0;
    $data ["dscvstotal"][0]->sep_com = ($dsc[0]->sep_com+$isc[0]->sep_com) != 0 ? 100*($dsc[0]->sep_com)/($dsc[0]->sep_com+$isc[0]->sep_com):0;
    $data ["dscvstotal"][0]->oct_com = ($dsc[0]->oct_com+$isc[0]->oct_com) != 0 ? 100*($dsc[0]->oct_com)/($dsc[0]->oct_com+$isc[0]->oct_com):0;
    $data ["dscvstotal"][0]->nov_com = ($dsc[0]->nov_com+$isc[0]->nov_com) != 0 ? 100*($dsc[0]->nov_com)/($dsc[0]->nov_com+$isc[0]->nov_com):0;
    $data ["dscvstotal"][0]->dec_com = ($dsc[0]->dec_com+$isc[0]->dec_com) != 0 ? 100*($dsc[0]->dec_com)/($dsc[0]->dec_com+$isc[0]->dec_com):0;

    $data ["theoreticalCapacity"] = $theoreticalCapacity;
    $data ["theoreticalCapacity"] = [];
    $data ["theoreticalCapacity"][0] = new \stdClass();
    $data ["theoreticalCapacity"][0]->year = $inputs['year'][0];
    $data ["theoreticalCapacity"][0]->jan_com = $theoreticalCapacity[0];
    $data ["theoreticalCapacity"][0]->feb_com = $theoreticalCapacity[1];
    $data ["theoreticalCapacity"][0]->mar_com = $theoreticalCapacity[2];
    $data ["theoreticalCapacity"][0]->apr_com = $theoreticalCapacity[3];
    $data ["theoreticalCapacity"][0]->may_com = $theoreticalCapacity[4];
    $data ["theoreticalCapacity"][0]->jun_com = $theoreticalCapacity[5];
    $data ["theoreticalCapacity"][0]->jul_com = $theoreticalCapacity[6];
    $data ["theoreticalCapacity"][0]->aug_com = $theoreticalCapacity[7];
    $data ["theoreticalCapacity"][0]->sep_com = $theoreticalCapacity[8];
    $data ["theoreticalCapacity"][0]->oct_com = $theoreticalCapacity[9];
    $data ["theoreticalCapacity"][0]->nov_com = $theoreticalCapacity[10];
    $data ["theoreticalCapacity"][0]->dec_com = $theoreticalCapacity[11];

    $data ["dsc"] = $dsc;
    $data ["isc"] = $isc;
    $data ["orange"] = $orange;
    $data ["presales"] = $presales;

    //dd($data);

    return json_encode($data);
  }
  public function test ()
  {
    return $this->activityRepository->test();
  }
}

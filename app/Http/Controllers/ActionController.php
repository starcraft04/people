<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Entrust;
use Auth;
use App\Action;

class ActionController extends Controller {

  public function __construct()
  {

	}
	public function actionList(Request $request)
	{
    $inputs = $request->all();
    //dd($inputs);

    $actionList = DB::table('actions');
    $actionList->select('actions.id AS action_id','created_by.id AS created_by_id','created_by.name AS created_by_name',
                        'assigned.id AS assigned_to_id','assigned.name AS assigned_to_name','actions.name AS action_name',
                        'actions.section AS action_section','actions.severity AS action_severity',
                        'actions.status AS action_status','actions.project_id AS project_id','projects.project_name AS project_name',
                        'actions.estimated_start_date AS action_estimated_start_date','actions.estimated_end_date AS action_estimated_end_date',
                        'actions.description AS action_description'
    );
    $actionList->leftjoin('users AS assigned', 'actions.assigned_user_id', '=', 'assigned.id');
    $actionList->leftjoin('users AS created_by', 'actions.user_id', '=', 'created_by.id');
    $actionList->leftjoin('projects', 'actions.project_id', '=', 'projects.id');

    if (!empty($inputs['user']))
    {
      $actionList->where(function ($query) use ($inputs) {
        foreach ($inputs['user'] as $i)
        {
          $query->orWhere('actions.assigned_user_id',$i);
        }
      });
    };

    if (isset($inputs['section'])) {
      $actionList->where('section',$inputs['section']);
    }

    if (isset($inputs['project_id'])) {
      $actionList->where('project_id',$inputs['project_id']);
    }

    if (isset($inputs['hide_closed']) && $inputs['hide_closed'] == 'true') {
      $actionList->where('actions.status','!=','closed');
    }

		$data = $actionList->get();

    return $data;
  }

  public function actionInsertUpdate(Request $request)
	{
    $inputs = $request->all();
    $result = new \stdClass();
    $id = $inputs["id"];
    unset($inputs["id"]);
    if ($inputs["project_id"] == "null") {
      unset($inputs["project_id"]);
    }

    if (!isset($id)) {
      $insert_result = Action::insert($inputs);
      if ($insert_result != null) {
        $result->result = 'success';
        $result->box_type = 'success';
        $result->message_type = 'success';
        $result->msg = 'Record added successfully';
      } else {
        $result->result = 'error';
        $result->box_type = 'danger';
        $result->message_type = 'error';
        $result->msg = 'Record issue';
      }
    } else {
      $update_result = Action::find($id);
      $update_result->update($inputs);
      if ($update_result != null) {
        $result->result = 'success';
        $result->box_type = 'success';
        $result->message_type = 'success';
        $result->msg = 'Record updated successfully';
      } else {
        $result->result = 'error';
        $result->box_type = 'danger';
        $result->message_type = 'error';
        $result->msg = 'Record issue';
      }
    }
    
    return json_encode($result);
  }

  public function actionDelete(Request $request)
	{
    $inputs = $request->all();
    $result = new \stdClass();
    $delete_result = Action::find($inputs['id']);

    if ($delete_result->user_id == Auth::user()->id || Entrust::can('action-all')) {
      $delete_result->delete();
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
}

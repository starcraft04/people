<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Loe;
use App\User;
use App\LoeHistory;
use App\LoeSite;
use App\LoeConsultant;
use NXP\MathExecutor;
use App\Http\Controllers\Auth\AuthUsersForDataView;
use App\Customer;
use App\Project;
use App\ConsultingPricing;

class LoeController extends Controller
{
    public function listFromProjectID($id)
    {
        $results = array();
        $loe_data = Loe::where('project_id',$id)
                    ->orderBy('main_phase','asc')
                    ->orderBy('secondary_phase','asc')
                    ->orderBy('domain','asc')
                    ->orderBy('description','asc')
                    ->get();

        if (count($loe_data) > 0) {
            // Domains
            $domains = [];
            foreach ($loe_data as $key => $domain) {
                if (!in_array($domain->domain, $domains)){
                    array_push($domains,$domain->domain);
                }
            }

            // Col Sites
            $col_sites = DB::table('project_loe');
            $col_sites->select('site.name');
            $col_sites->join('project_loe_site AS site', 'project_loe.id', '=', 'site.project_loe_id');
            $col_sites->where('project_id',$id);
            $col_sites->groupBy('site.name');
            $col_sites->orderBy('site.name','asc');
            $data_col_sites = $col_sites->get();

            // Col Consultants
            $col_cons = DB::table('project_loe');
            $col_cons->select('consultant.name','consultant.location','consultant.seniority');
            $col_cons->join('project_loe_consultant AS consultant', 'project_loe.id', '=', 'consultant.project_loe_id');
            $col_cons->where('project_id',$id);
            $col_cons->groupBy('consultant.name');
            $col_cons->orderBy('consultant.name','asc');
            $data_col_cons = $col_cons->get();
            foreach ($data_col_cons as $key => $cons) {
                // If all validation test are good we execute the create
                $cons_price = ConsultingPricing::where('country',$cons->location)->where('role',$cons->seniority)->first();
                if (!empty($cons_price)) {
                    $price = $cons_price->unit_price;
                    $cost = $cons_price->unit_cost;
                } else {
                    $price = 0;
                    $cost = 0;
                }
                $data_col_cons[$key]->price = $price;
                $data_col_cons[$key]->cost = $cost;
            }

            // Sites
            $sites = DB::table('project_loe');
            $sites->select('site.id','site.project_loe_id','site.name','site.quantity','site.loe_per_quantity');
            $sites->join('project_loe_site AS site', 'project_loe.id', '=', 'site.project_loe_id');
            $sites->where('project_id',$id);
            $data_sites = $sites->get();

            
                // Format for easy use
            $data_sites_formatted = array();
            foreach ($data_sites as $key => $row) {
                
                if (empty($data_sites_formatted[$row->project_loe_id])) {
                    $data_sites_formatted[$row->project_loe_id] = array();
                }
                $data_sites_formatted[$row->project_loe_id][$row->name] = array();
                $data_sites_formatted[$row->project_loe_id][$row->name]['id'] = $row->id;
                $data_sites_formatted[$row->project_loe_id][$row->name]['quantity'] = $row->quantity;
                $data_sites_formatted[$row->project_loe_id][$row->name]['loe_per_quantity'] = $row->loe_per_quantity;
            }

            //dd($data_sites_formatted);

            // Consultants
            $consultants = DB::table('project_loe');
            $consultants->select('consultant.id','consultant.project_loe_id','consultant.name','consultant.percentage','consultant.price','consultant.cost');
            $consultants->join('project_loe_consultant AS consultant', 'project_loe.id', '=', 'consultant.project_loe_id');
            $consultants->where('project_id',$id);
            $consultants->orderBy('consultant.name','asc');
            $data_consultants = $consultants->get();

                // Format for easy use
            $data_consultants_formatted = array();
            foreach ($data_consultants as $key => $row) {
                if (empty($data_consultants_formatted[$row->project_loe_id])) {
                    $data_consultants_formatted[$row->project_loe_id] = array();
                }
                $data_consultants_formatted[$row->project_loe_id][$row->name]['id'] = $row->id;
                $data_consultants_formatted[$row->project_loe_id][$row->name]['percentage'] = $row->percentage;
                $data_consultants_formatted[$row->project_loe_id][$row->name]['cost'] = $row->cost;
                $data_consultants_formatted[$row->project_loe_id][$row->name]['price'] = $row->price;
            }

            
            $results['col'] = array();
            $results['col']['site'] = $data_col_sites;
            $results['col']['cons'] = $data_col_cons;
            $results['col']['domains'] = $domains;
            $results['data'] = array();
            $results['data']['loe'] = $loe_data;
            $results['data']['site'] = $data_sites_formatted;
            $results['data']['cons'] = $data_consultants_formatted;
        }
        return $results;
    }

    public function loeHistory($id)
    {
        $loe_history = LoeHistory::join('project_loe', 'project_loe.id', '=', 'project_loe_history.project_loe_id')
            ->join('users','users.id','=','project_loe_history.user_id')
            ->select('users.name','project_loe.main_phase','project_loe.secondary_phase','project_loe.description AS loe_desc',
                    'project_loe_history.description AS history_desc','project_loe_history.created_at','project_loe_history.field_modified',
                    'project_loe_history.field_old_value','project_loe_history.field_new_value','project_loe_history.project_loe_id'
            )
            ->where('project_loe.project_id',$id)
            ->orderBy('project_loe_history.created_at','asc')
            ->get();

        return $loe_history;
    }

    public function init($id)
    {
        $result = new \stdClass();
        $inputs = [
            'project_id' => $id,
            'user_id' => Auth::user()->id,
            'quantity' => 1,
            'loe_per_quantity' => 0,
            'first_line' => 1
        ];
        $insert_result = Loe::create($inputs);
        if ($insert_result != null) {
            LoeHistory::create([
                'project_loe_id' => $insert_result->id,
                'user_id' => Auth::user()->id,
                'description' => 'LoE table created'
            ]);
            $result->result = 'success';
            $result->msg = 'LoE initiated successfuly';
        } else {
            $result->result = 'error';
            $result->msg = 'Record issue';
        }
        
        return json_encode($result);
    }

    public function site_delete(Request $request, $id)
    {
        $result = new \stdClass();
        $inputs = $request->all();

        $formulas = Loe::select('main_phase','secondary_phase','description','formula')
                        ->where('project_id',$id)
                        ->get();

        $found = False;
        $found_where = '';

        foreach ($formulas as $key => $formula) {
            $str = $formula->formula;
            $substr = "{{".$inputs['name']."}}";
            
            if (strpos($str, $substr) !== false) {
                $found = True;
                $found_where = $formula->main_phase.'-'.$formula->secondary_phase.'-'.$formula->description;
                break;
            }
        }

        if ($found) {
            $result->result = 'error';
            $result->msg = 'This calculation cannot be deleted because it is used in a formula in the record with description:<br>'.$found_where;
            return json_encode($result);
        } else {
            $records = LoeSite::join('project_loe', 'project_loe.id', '=', 'project_loe_site.project_loe_id')
                        ->where('project_id',$id)
                        ->where('name',$inputs['name'])
                        ->delete();
            $result->result = 'success';
            $result->msg = 'Calculation deleted successfuly';

            return json_encode($result);
        }

    }

    public function site_create(Request $request,$id)
    {
        $result = new \stdClass();
        $inputs = $request->all();

        //validation process
        if (empty($inputs['name'])) {
            $result->result = 'validation_errors';
            $result->errors = array();
            $result->errors[0] = array();
            $result->errors[0]['field'] = 'name';
            $result->errors[0]['msg'] = 'This field cannot be empty';
            return json_encode($result);
        }

        $alphanum = preg_match("/^[a-zA-Z0-9][a-zA-Z0-9-_]*[a-zA-Z0-9]$/",$inputs['name']);
        if ($alphanum == 0) {
            $result->result = 'validation_errors';
            $result->errors = array();
            $result->errors[0] = array();
            $result->errors[0]['field'] = 'name';
            $result->errors[0]['msg'] = 'Must start and end with alphanumeric and only use alphanumeric or - or _';
            return json_encode($result);
        }

        $records = LoeSite::join('project_loe', 'project_loe.id', '=', 'project_loe_site.project_loe_id')
                        ->where('project_id',$id)
                        ->where('name',$inputs['name'])
                        ->get();           

        if (count($records)>0) {
            $result->result = 'validation_errors';            
            $result->errors = array();
            $result->errors[0] = array();
            $result->errors[0]['field'] = 'name';
            $result->errors[0]['msg'] = 'This name already exists';

            return json_encode($result);
        } else {
            $loes = Loe::where('project_id',$id)
                                ->get();
            // If all validation test are good we execute the create
            foreach ($loes as $key => $loe) {
                $records = LoeSite::create(
                    [
                        'project_loe_id'=>$loe->id,
                        'name'=>$inputs['name'],
                        'quantity'=>0,
                        'loe_per_quantity'=>0
                    ]);
            }
            

            $result->result = 'success';
            $result->msg = 'Calculation created successfuly';

            return json_encode($result);
        }
    }

    public function site_edit(Request $request,$id)
    {
        $result = new \stdClass();
        $inputs = $request->all();
        
        //validation process
        if (empty($inputs['name'])) {
            $result->result = 'validation_errors';
            $result->errors = array();
            $result->errors[0] = array();
            $result->errors[0]['field'] = 'name';
            $result->errors[0]['msg'] = 'This field cannot be empty';
            return json_encode($result);
        }

        $alphanum = preg_match("/^[a-zA-Z0-9][a-zA-Z0-9-_]*[a-zA-Z0-9]$/",$inputs['name']);
        if ($alphanum == 0) {
            $result->result = 'validation_errors';
            $result->errors = array();
            $result->errors[0] = array();
            $result->errors[0]['field'] = 'name';
            $result->errors[0]['msg'] = 'Must start and end with alphanumeric and only use alphanumeric or - or _';
            return json_encode($result);
        }

        $records = LoeSite::join('project_loe', 'project_loe.id', '=', 'project_loe_site.project_loe_id')
                        ->where('project_id',$id)
                        ->where('name',$inputs['name'])
                        ->get();

        if (count($records)>0) {
            $result->result = 'validation_errors';            
            $result->errors = array();
            $result->errors[0] = array();
            $result->errors[0]['field'] = 'name';
            $result->errors[0]['msg'] = 'This name already exists';

            return json_encode($result);
        } else {
            // If all validation test are good we execute the update
            $formulas = Loe::select('id','formula')
                        ->where('project_id',$id)
                        ->where('formula','LIKE','%{{'.$inputs['old_name'].'}}%')
                        ->get();

            foreach ($formulas as $key => $formula) {
                $str = $formula->formula;
                $new_formula = str_replace($inputs['old_name'],$inputs['name'],$str);
                Loe::find($formula->id)->update(['formula'=>$new_formula]);
            }

            $records = LoeSite::join('project_loe', 'project_loe.id', '=', 'project_loe_site.project_loe_id')
                        ->where('project_id',$id)
                        ->where('name',$inputs['old_name'])
                        ->update(['name'=>$inputs['name']]);

            $result->result = 'success';
            $result->msg = 'Calculation updated successfuly';

            return json_encode($result);
        }
    }

    public function cons_delete(Request $request, $id)
    {
        $result = new \stdClass();
        $inputs = $request->all();

        $consultings = LoeConsultant::join('project_loe', 'project_loe.id', '=', 'project_loe_consultant.project_loe_id')
                        ->select('percentage')
                        ->where('project_loe.project_id',$id)
                        ->where('name',$inputs['name'])
                        ->get();

        $found = False;

        foreach ($consultings as $key => $consulting) {
            if ($consulting->percentage != 0) {
                $found = True;
                break;
            }
        }

        if ($found) {
            $result->result = 'error';
            $result->msg = 'This consultant type cannot be deleted because it has at least one record different from 0';
            return json_encode($result);
        } else {
            $records = LoeConsultant::join('project_loe', 'project_loe.id', '=', 'project_loe_consultant.project_loe_id')
                        ->where('project_id',$id)
                        ->where('name',$inputs['name'])
                        ->delete();
            $result->result = 'success';
            $result->msg = 'Consultant type deleted successfuly';

            return json_encode($result);
        }

    }
    public function cons_create(Request $request,$id)
    {
        $result = new \stdClass();
        $inputs = $request->all();

        //validation process
        if (empty($inputs['name'])) {
            $result->result = 'validation_errors';
            $result->errors = array();
            $result->errors[0] = array();
            $result->errors[0]['field'] = 'name';
            $result->errors[0]['msg'] = 'This field cannot be empty';
            return json_encode($result);
        }

        $alphanum = preg_match("/^[a-zA-Z0-9][a-zA-Z0-9-_]*[a-zA-Z0-9]$/",$inputs['name']);
        if ($alphanum == 0) {
            $result->result = 'validation_errors';
            $result->errors = array();
            $result->errors[0] = array();
            $result->errors[0]['field'] = 'name';
            $result->errors[0]['msg'] = 'Must start and end with alphanumeric and only use alphanumeric or - or _';
            return json_encode($result);
        }

        $records = LoeConsultant::join('project_loe', 'project_loe.id', '=', 'project_loe_consultant.project_loe_id')
                        ->where('project_id',$id)
                        ->where('name',$inputs['name'])
                        ->get();           

        if (count($records)>0) {
            $result->result = 'validation_errors';            
            $result->errors = array();
            $result->errors[0] = array();
            $result->errors[0]['field'] = 'name';
            $result->errors[0]['msg'] = 'This name already exists';

            return json_encode($result);
        } else {
            $loes = Loe::where('project_id',$id)
                                ->get();

            // If all validation test are good we execute the create
            $cons_price = ConsultingPricing::where('country',$inputs['location'])->where('role',$inputs['seniority'])->first();
            if (!empty($cons_price)) {
                $price = $cons_price->unit_price;
                $cost = $cons_price->unit_cost;
            } else {
                $price = 0;
                $cost = 0;
            }
            foreach ($loes as $key => $loe) {

                $records = LoeConsultant::create(
                    [
                        'project_loe_id'=>$loe->id,
                        'name'=>$inputs['name'],
                        'location'=>$inputs['location'],
                        'seniority'=>$inputs['seniority'],
                        'percentage'=>0,
                        'price'=>$price,
                        'cost'=>$cost
                    ]);
            }
            

            $result->result = 'success';
            $result->msg = 'Consultant type created successfuly';

            return json_encode($result);
        }
    }

    public function cons_edit(Request $request,$id)
    {
        $result = new \stdClass();
        $inputs = $request->all();
        
        //validation process
        if (empty($inputs['name'])) {
            $result->result = 'validation_errors';
            $result->errors = array();
            $result->errors[0] = array();
            $result->errors[0]['field'] = 'name';
            $result->errors[0]['msg'] = 'This field cannot be empty';
            return json_encode($result);
        }

        $alphanum = preg_match("/^[a-zA-Z0-9][a-zA-Z0-9-_]*[a-zA-Z0-9]$/",$inputs['name']);
        if ($alphanum == 0) {
            $result->result = 'validation_errors';
            $result->errors = array();
            $result->errors[0] = array();
            $result->errors[0]['field'] = 'name';
            $result->errors[0]['msg'] = 'Must start and end with alphanumeric and only use alphanumeric or - or _';
            return json_encode($result);
        }

        if ($inputs['name'] != $inputs['old_name']) {
            $records = LoeConsultant::join('project_loe', 'project_loe.id', '=', 'project_loe_consultant.project_loe_id')
                        ->where('project_id',$id)
                        ->where('name',$inputs['name'])
                        ->get();

            if (count($records)>0) {
                $result->result = 'validation_errors';            
                $result->errors = array();
                $result->errors[0] = array();
                $result->errors[0]['field'] = 'name';
                $result->errors[0]['msg'] = 'This name already exists';

                return json_encode($result);
            }
        }

        // If all validation test are good we execute the update
        $records = LoeConsultant::join('project_loe', 'project_loe.id', '=', 'project_loe_consultant.project_loe_id')
                    ->where('project_id',$id)
                    ->where('name',$inputs['old_name'])
                    ->update([
                        'name'=>$inputs['name'],
                        'location'=>$inputs['location'],
                        'seniority'=>$inputs['seniority']
                        ]);

        $result->result = 'success';
        $result->msg = 'Consultant type updated successfuly';

        return json_encode($result);
    }

    public function delete($id)
    {
        $result = new \stdClass();

        $loe_to_delete = Loe::find($id);


        if ($loe_to_delete->user_id != Auth::user()->id && !Auth::user()->can('projectLoe-deleteAll')) {
            $result->result = 'error';
            $result->msg = 'You cannot delete this LoE as you did not create it';
            return json_encode($result);
        }

        $list_with_same_project_id = Loe::where('project_id',$loe_to_delete->project_id)->get();
        $num_of_loe = $list_with_same_project_id->count();

        if ($loe_to_delete->first_line == 1 && $num_of_loe > 1) {
            $result->result = 'error';
            $result->msg = 'For integrity of the tool, the first line created must be deleted when all other lines have been deleted.';

        return json_encode($result);
        }

        $history = LoeHistory::where('project_loe_id',$id)->get();

        if($history){
            LoeHistory::where('project_loe_id',$id)->delete();
        }

        $site = LoeSite::where('project_loe_id',$id)->get();

        if($site){
            LoeSite::where('project_loe_id',$id)->delete();
        }

        $consultant = LoeConsultant::where('project_loe_id',$id)->get();
        if($consultant){
            LoeConsultant::where('project_loe_id',$id)->delete();
        }
        Loe::find($id)->delete();

        $result->result = 'success';
        $result->msg = 'Record deleted successfuly';

        return json_encode($result);
    }

    public function duplicate($id)
    {
        $result = new \stdClass();

        $origin = Loe::find($id);

        $new = Loe::create([
            'project_id' => $origin->project_id,
            'user_id' => Auth::user()->id,
            'main_phase' => $origin->main_phase,
            'secondary_phase' => $origin->secondary_phase,
            'domain' => $origin->domain,
            'description' => $origin->description,
            'option' => $origin->option,
            'assumption' => $origin->assumption,
            'quantity' => $origin->quantity,
            'loe_per_quantity' => $origin->loe_per_quantity,
            'formula' => $origin->formula,
            'recurrent' => $origin->recurrent,
            'start_date' => $origin->start_date,
            'end_date' => $origin->end_date
        ]);

        $origin_site = LoeSite::where('project_loe_id',$id)->get();

        foreach ($origin_site as $key => $site) {
            $new_site = LoeSite::create([
                'project_loe_id' => $new->id,
                'name' => $site->name,
                'quantity' => $site->quantity,
                'loe_per_quantity' => $site->loe_per_quantity
            ]);
        }

        $origin_consultant = LoeConsultant::where('project_loe_id',$id)->get();

        foreach ($origin_consultant as $key => $consultant) {
            $new_consultant = LoeConsultant::create([
                'project_loe_id' => $new->id,
                'name' => $consultant->name,
                'location' => $consultant->location,
                'seniority' => $consultant->seniority,
                'cost' => $consultant->cost,
                'price' => $consultant->price,
                'percentage' => $consultant->percentage
            ]);
        }

        $result->result = 'success';
        $result->msg = 'Record duplicated successfuly';

        return json_encode($result);
    }

    public function create_update(Request $request,$id)
    {
        $result = new \stdClass();
        $result->result = 'success';

        $inputs = $request->all();
        $cons = json_decode($inputs['cons'], true);
        $sites = json_decode($inputs['site'], true);

        if ($inputs['action'] == 'update') {
            $loe = Loe::find($id);
            if ($loe->user_id != Auth::user()->id && !Auth::user()->can('projectLoe-editAll')) {
                $result->result = 'error';
                $result->msg = 'You cannot update this LoE as you did not create it';
                return json_encode($result);
            }
        }
            
        if ($inputs['action'] == 'create') {
            $result->msg = 'LoE created';
        } else {
            $result->msg = 'LoE updated';
        }
        
        //$result->sites = $sites;

        $result->errors = [];

        //region validation process

        //sites not empty
        $one_site_empty = False;
        foreach ($sites as $key => $site) {
            if ($site['quantity'] == null) {
                $result->result = 'validation_errors';
                $error = [];
                $error['field'] = 'site_quantity_'.$site['name'];
                $error['msg'] = 'Cannot be empty';
                array_push($result->errors,$error);
                $one_site_empty = True;
            }
            if ($site['loe_per_quantity'] == null) {
                $result->result = 'validation_errors';
                $error = [];
                $error['field'] = 'site_loe_per_quantity_'.$site['name'];
                $error['msg'] = 'Cannot be empty';
                array_push($result->errors,$error);
                $one_site_empty = True;
            }
        }
        //quantity not empty
        if ($inputs['quantity'] == null) {
            $result->result = 'validation_errors';
            $error = [];
            $error['field'] = 'quantity';
            $error['msg'] = 'Cannot be empty';
            array_push($result->errors,$error);
        }
        //loe_per_quantity not empty and check if recurrent then between 0 and 1
        if ($inputs['loe_per_quantity'] == null) {
            $result->result = 'validation_errors';
            $error = [];
            $error['field'] = 'loe_per_quantity';
            $error['msg'] = 'Cannot be empty';
            array_push($result->errors,$error);
        } else if ($inputs['recurrent'] == 1 && ($inputs['loe_per_quantity']<0 || $inputs['loe_per_quantity']>1)) {
            $result->result = 'validation_errors';
            $error = [];
            $error['field'] = 'loe_per_quantity';
            $error['msg'] = 'If recurrent is selected, must be between 0 and 1';
            array_push($result->errors,$error);
        }
        //cons not empty and percentage between 0 and 100
        $percent_total = 0;
        foreach ($cons as $key => $cons_type) {
            if ($cons_type['percentage'] == null) {
                $result->result = 'validation_errors';
                $error = [];
                $error['field'] = 'cons_percentage_'.$cons_type['name'];
                $error['msg'] = 'Cannot be empty';
                array_push($result->errors,$error);
            } else if ($cons_type['percentage'] < 0 || $cons_type['percentage'] > 100) {
                $result->result = 'validation_errors';
                $error = [];
                $error['field'] = 'cons_percentage_'.$cons_type['name'];
                $error['msg'] = 'Must be between 0 and 100';
                array_push($result->errors,$error);
            } else {
                $percent_total += $cons_type['percentage'];
            }

            if ($cons_type['cost'] == null) {
                $result->result = 'validation_errors';
                $error = [];
                $error['field'] = 'cons_cost_'.$cons_type['name'];
                $error['msg'] = 'Cannot be empty';
                array_push($result->errors,$error);
            }

            if ($cons_type['price'] == null) {
                $result->result = 'validation_errors';
                $error = [];
                $error['field'] = 'cons_price_'.$cons_type['name'];
                $error['msg'] = 'Cannot be empty';
                array_push($result->errors,$error);
            }
        }
        if ($percent_total != 0 && $percent_total != 100) {
            foreach ($cons as $key => $cons_type) {
                $result->result = 'validation_errors';
                $error = [];
                $error['field'] = 'cons_percentage_'.$cons_type['name'];
                $error['msg'] = 'The sum must be 100';
                array_push($result->errors,$error);
            }
        }

        //check dates when recurrent
        if ($inputs['recurrent'] == 1) {
            if ($inputs['start_date'] == null) {
                $result->result = 'validation_errors';
                $error = [];
                $error['field'] = 'start_date';
                $error['msg'] = 'If recurrent is selected, cannot be empty';
                array_push($result->errors,$error);
            }
            if ($inputs['end_date'] == null) {
                $result->result = 'validation_errors';
                $error = [];
                $error['field'] = 'end_date';
                $error['msg'] = 'If recurrent is selected, cannot be empty';
                array_push($result->errors,$error);
            }
        } else if ($inputs['start_date'] == null && $inputs['end_date'] != null) {
            $result->result = 'validation_errors';
            $error = [];
            $error['field'] = 'start_date';
            $error['msg'] = 'If end date is selected, cannot be empty';
            array_push($result->errors,$error);
        } else if ($inputs['start_date'] != null && $inputs['end_date'] == null) {
            $result->result = 'validation_errors';
            $error = [];
            $error['field'] = 'end_date';
            $error['msg'] = 'If start date is selected, cannot be empty';
            array_push($result->errors,$error);
        }
        //check start < end date
        $start_date = new \DateTime($inputs['start_date']);
        $end_date = new \DateTime($inputs['end_date']);
        if (($inputs['start_date'] != null && $inputs['end_date'] != null) && $end_date < $start_date) {
            $result->result = 'validation_errors';
            $error = [];
            $error['field'] = 'start_date';
            $error['msg'] = 'start date must be before end date';
            array_push($result->errors,$error);
        }

        $new_formula = $inputs['formula'];
        $new_formula_validated = False;
        //check formulas
        if ($new_formula != null) {
            if ($inputs['recurrent'] == 1) {
                $result->result = 'validation_errors';
                $error = [];
                $error['field'] = 'recurrent';
                $error['msg'] = 'Recurrent cannot be set up when formula is used';
                array_push($result->errors,$error);
            } else {
                if ($one_site_empty) {
                    $result->result = 'validation_errors';
                    $error = [];
                    $error['field'] = 'formula';
                    $error['msg'] = 'To evaluate formula, no calculation field can be empty';
                    array_push($result->errors,$error);
                } else {
                    foreach ($sites as $key => $site) {
                        $product = $site['quantity']*$site['loe_per_quantity'];
                        $new_formula = str_replace("{{".$site['name']."}}",$product,$new_formula);
                    }
                    $alphanum = preg_match("/^(-?[0-9.]+[\+\-\*\/])+[0-9.]+$/",$new_formula);
                    if ($alphanum == 0) {
                        $result->result = 'validation_errors';
                        $error = [];
                        $error['field'] = 'formula';
                        $error['msg'] = 'There is a problem with your formula: '.$new_formula;
                        array_push($result->errors,$error);
                    } else {
                        $new_formula_validated = True;
                    }
                }    
            }
            
        }

        if ($new_formula_validated) {
            $executor = new MathExecutor();
            // If division by 0 then equals 0
            $inputs['loe_per_quantity'] = $executor->setDivisionByZeroIsZero()->execute($new_formula);
        }

        //endregion

        if ($result->result != 'validation_errors') {
            $loe_values = [
                'main_phase' => $inputs['main_phase'],
                'secondary_phase' => $inputs['secondary_phase'],
                'domain' => $inputs['domain'],
                'description' => $inputs['description'],
                'option' => $inputs['option'],
                'assumption' => $inputs['assumption'],
                'quantity' => $inputs['quantity'],
                'loe_per_quantity' => $inputs['loe_per_quantity'],
                'formula' => $inputs['formula'],
                'recurrent' => $inputs['recurrent'],
                'start_date' => $inputs['start_date'],
                'end_date' => $inputs['end_date']
            ];
    
            if ($inputs['action'] == 'create') {
                $loe_values['project_id'] = $inputs['project_id'];
                $loe_values['user_id'] = Auth::user()->id;
                $loe = Loe::create($loe_values);
            } else {
                if ($loe->quantity != $loe_values['quantity']) {
                    LoeHistory::create([
                        'project_loe_id' => $id,
                        'user_id' => Auth::user()->id,
                        'description' => 'Value modified',
                        'field_modified' => 'Quantity',
                        'field_old_value' => $loe->quantity,
                        'field_new_value' => $loe_values['quantity'],
                    ]);
                }
                if ($loe->loe_per_quantity != $loe_values['loe_per_quantity']) {
                    LoeHistory::create([
                        'project_loe_id' => $id,
                        'user_id' => Auth::user()->id,
                        'description' => 'Value modified',
                        'field_modified' => 'Loe per Quantity',
                        'field_old_value' => $loe->loe_per_quantity,
                        'field_new_value' => $loe_values['loe_per_quantity'],
                    ]);
                }
                $loe->update($loe_values);
            }
    
            foreach ($sites as $key => $site) {
                LoeSite::updateOrCreate(
                    [
                        'project_loe_id' => $loe->id, 
                        'name' => $site['name']
                    ],
                    [
                        'quantity' => $site['quantity'],
                        'loe_per_quantity' => $site['loe_per_quantity']
                    ]
                );
            }
    
            foreach ($cons as $key => $cons_type) {
                if ($inputs['action'] == 'update') {
                    $loe_consultant = LoeConsultant::where('project_loe_id',$loe->id)->where('name',$cons_type['name'])->first();
                    if ($loe_consultant->cost != $cons_type['cost']) {
                        LoeHistory::create([
                            'project_loe_id' => $loe->id,
                            'user_id' => Auth::user()->id,
                            'description' => 'Value consulting type "'.$cons_type['name'].'" modified',
                            'field_modified' => 'Cost',
                            'field_old_value' => $loe_consultant->cost,
                            'field_new_value' => $cons_type['cost'],
                        ]);
                    }
                    if ($loe_consultant->price != $cons_type['price']) {
                        LoeHistory::create([
                            'project_loe_id' => $loe->id,
                            'user_id' => Auth::user()->id,
                            'description' => 'Value consulting type "'.$cons_type['name'].'" modified',
                            'field_modified' => 'Price',
                            'field_old_value' => $loe_consultant->price,
                            'field_new_value' => $cons_type['price'],
                        ]);
                    }
                    if ($loe_consultant->percentage != $cons_type['percentage']) {
                        LoeHistory::create([
                            'project_loe_id' => $loe->id,
                            'user_id' => Auth::user()->id,
                            'description' => 'Value consulting type "'.$cons_type['name'].'" modified',
                            'field_modified' => 'Percentage',
                            'field_old_value' => $loe_consultant->percentage,
                            'field_new_value' => $cons_type['percentage'],
                        ]);
                    }
                }
                LoeConsultant::updateOrCreate(
                    [
                        'project_loe_id' => $loe->id, 
                        'name' => $cons_type['name']
                    ],
                    [
                        'cost' => $cons_type['cost'],
                        'price' => $cons_type['price'],
                        'percentage' => $cons_type['percentage']
                    ]
                );
            }
        }

        return json_encode($result);
    }

    public function signoff($id)
    {
        $result = new \stdClass();

        $loe = Loe::find($id);



        if ($loe->signoff_user_id == null) {
            LoeHistory::create([
                'project_loe_id' => $id,
                'user_id' => Auth::user()->id,
                'description' => 'Value modified',
                'field_modified' => 'Signoff',
                'field_old_value' => 'unset',
                'field_new_value' => Auth::user()->name,
            ]);
            $loe->signoff_user_id = Auth::user()->id;
        } else {
            $user = User::find($loe->signoff_user_id);
            LoeHistory::create([
                'project_loe_id' => $id,
                'user_id' => Auth::user()->id,
                'description' => 'Value modified',
                'field_modified' => 'Signoff',
                'field_old_value' => $user->name,
                'field_new_value' => 'unset',
            ]);
            $loe->signoff_user_id = null;
        }

        $loe->save();

        $result->result = 'success';
        $result->msg = 'Record signed off successfuly';

        return json_encode($result);
    }

    public function masssignoff(Request $request,$id)
    {
        $result = new \stdClass();
        $result->result = 'success';
        $result->msg = 'Mass sign off success';

        $inputs = $request->all();
        if ($inputs['domain'] == 'All') {
            $loes = Loe::where('project_id',$id)->get();
        } else {
            $loes = Loe::where('project_id',$id)->where('domain',$inputs['domain'])->get();
        }
        
        foreach ($loes as $key => $loe) {
            Loe::find($loe->id);
            if ($loe->signoff_user_id == null) {
                LoeHistory::create([
                    'project_loe_id' => $loe->id,
                    'user_id' => Auth::user()->id,
                    'description' => 'Value modified',
                    'field_modified' => 'Signoff',
                    'field_old_value' => 'unset',
                    'field_new_value' => Auth::user()->name,
                ]);
            }
            $loe->signoff_user_id = Auth::user()->id;
            $loe->save();
            
        }


        return json_encode($result);
    }

    public function dashboard()
    {
        $customers_list = Customer::leftjoin('projects','projects.customer_id','=','customers.id')
        ->leftjoin('project_loe','project_loe.project_id','=','projects.id')
        ->whereNotNull('project_loe.id')
        ->pluck('customers.name', 'customers.id');

        return view('dashboard/loe', compact('customers_list'));
    }

    public function dashboardProjects($id)
    {
        $project_list = Project::leftjoin('project_loe','project_loe.project_id','=','projects.id')
                ->select('projects.id','projects.project_name')
                ->where('projects.customer_id', $id)
                ->whereNotNull('project_loe.id')
                ->groupBy('projects.id')
                ->get();

        return json_encode($project_list);
    }
}

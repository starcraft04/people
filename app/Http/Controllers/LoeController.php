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
    //region LoE general
    public function view($id)
    {
        $project = Project::find($id);
        $customer = Customer::find($project->customer_id);
        $customers_list = Customer::leftjoin('projects','projects.customer_id','=','customers.id')
        ->leftjoin('project_loe','project_loe.project_id','=','projects.id')
        ->whereNotNull('project_loe.id')
        ->pluck('customers.name', 'customers.id');
        return view('loe/create_update', compact('project','customer','customers_list'));
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

        //Because we want to have some consulting columns to be created by default, we will call the existing function in this controller and give it a $request as if coming from the form
        //This will create the $request as it should be from a form in the main page
        $request = new Request([
            'name'   => 'Lead_consultant',
            'location' => 'Germany',
            'seniority' => 'Senior Consultant',
        ]);
        //This will call the function that is adding a consulting type to the LoE
        $this->cons_create($request,$id);

        $request = new Request([
            'name'   => 'Offshore_consultant',
            'location' => 'Egypt',
            'seniority' => 'Senior Consultant',
        ]);

        $this->cons_create($request,$id);
        
        return json_encode($result);
    }

    public function listFromProjectID($id)
    {
        $results = array();
        $loe_data = Loe::where('project_id',$id)
                    ->orderBy('row_order','asc')
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
    //endregion

    //region Sites
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
                        'quantity'=>1,
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
    //endregion

    //region Consulting
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
            //We check first the default prices
            $cons_price = ConsultingPricing::where('country',$inputs['location'])->where('role',$inputs['seniority'])->first();
            if (!empty($cons_price)) {
                $price = $cons_price->unit_price;
                $cost = $cons_price->unit_cost;
            } else {
                $price = 0;
                $cost = 0;
            }
            //If this is the first consulting type we add, we put the percentage to 100
            $cons_on_this_project = LoeConsultant::join('project_loe', 'project_loe.id', '=', 'project_loe_consultant.project_loe_id')
                                        ->where('project_id',$id)
                                        ->count();
            if ($cons_on_this_project == 0) {
                $percentage = 100;
            } else {
                $percentage = 0;
            }
            foreach ($loes as $key => $loe) {

                $records = LoeConsultant::create(
                    [
                        'project_loe_id'=>$loe->id,
                        'name'=>$inputs['name'],
                        'location'=>$inputs['location'],
                        'seniority'=>$inputs['seniority'],
                        'percentage'=>$percentage,
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

    public function cons_set_default(Request $request)
    {
        $result = new \stdClass();
        $inputs = $request->all();
        
        $pricing = ConsultingPricing::where('country',$inputs['location'])->where('role',$inputs['seniority'])->first();

        if (!is_null($pricing)) {
            $result->result = 'success';
            $result->msg = 'Default set successfuly';

            LoeConsultant::join('project_loe','project_loe_consultant.project_loe_id','=','project_loe.id')->where('project_loe.project_id',$inputs['project_id'])->update(['price'=>$pricing->unit_price,'cost'=>$pricing->unit_cost]);
        } else {
            $result->result = 'error';
            $result->msg = 'No default found';
        }

        return json_encode($result);
    }
    //endregion

    //region Row functions
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

        $result->num_of_records = $num_of_loe-1;

        if ($loe_to_delete->first_line == 1 && $result->num_of_records != 0) {
            //In case we need to delete the first line, we have to assign it to a new one and move the history create record to this new loe
            $new_loe_first_line = Loe::where('project_id',$loe_to_delete->project_id)->where('id','!=',$id)->first();
            $new_loe_first_line->update(['first_line'=>1]);
            LoeHistory::where('project_loe_id',$id)->where('description','LoE table created')->update(['project_loe_id' => $new_loe_first_line->id]);
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

        $this->reorder($id,0);
        Loe::find($id)->delete();

        $result->result = 'success';
        $result->msg = 'Record deleted successfuly';

        return json_encode($result);
    }

    public function create($id)
    {
        $result = new \stdClass();

        $origin = Loe::find($id);

        $num_of_rows = Loe::where('project_id',$origin->project_id)->count();

        $new = Loe::create([
            'project_id' => $origin->project_id,
            'user_id' => Auth::user()->id,
            'quantity' => 1,
            'loe_per_quantity' => 0,
            'first_line' => 0,
            'row_order' => $num_of_rows + 1
        ]);

        $this->reorder($new->id,$origin->row_order + 1);

        $origin_site = LoeSite::where('project_loe_id',$id)->get();

        foreach ($origin_site as $key => $site) {
            $new_site = LoeSite::create([
                'project_loe_id' => $new->id,
                'name' => $site->name,
                'quantity' => 1,
                'loe_per_quantity' => 0
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
                'percentage' => 0
            ]);
        }

        $result->result = 'success';
        $result->msg = 'Record created successfuly';

        return json_encode($result);
    }

    public function duplicate($id)
    {
        $result = new \stdClass();

        $origin = Loe::find($id);

        $num_of_rows = Loe::where('project_id',$origin->project_id)->count();

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
            'end_date' => $origin->end_date,
            'row_order' => $num_of_rows + 1
        ]);

        $this->reorder($new->id,$origin->row_order + 1);

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

    public function reorder($id,$new_row_order)
    {
        // This function will take the id of the record, look this in the database and select all records on the same project_id
        // It will then insert the record at the new_row_order and move the rest of the records
        $record = Loe::find($id);
        $rows = Loe::select('id','row_order')->where('project_id',$record->project_id)->where('id','!=',$id)->orderBy('row_order','asc')->get();
        $i = 1;
        foreach ($rows as $row) {
            if ($i == $new_row_order) {
                $i++;
            } 
            if ($row->row_order != $i) {
                $record_to_change = Loe::find($row->id);
                $record_to_change->update(['row_order' => $i]);
            }
            $i++;
        }
        $record->update(['row_order' => $new_row_order]);
    }

    public function append_template(Request $request)
    {
        $result = new \stdClass();
        $result->result = 'success';

        $inputs = $request->all();

        $template_loe = Loe::where('project_id',$inputs['template_project_id'])->orderBy('row_order')->get();
        
        if ($template_loe->count() > 0) {

            $this_loes = Loe::where('project_id',$inputs['this_project_id'])->get();
            //Now we need to delete all existing records for the project id
            foreach ($this_loes as $key => $this_loe) {
                $this->delete($this_loe->id);
            }

            //Now we can replicate all data from the template
            foreach ($template_loe as $key => $loe) {
                //Duplicate each loe from template
                $newLoe = $loe->replicate();
                $newLoe->project_id = $inputs['this_project_id']; // the new project_id
                $newLoe->user_id = Auth::user()->id;
                $newLoe->signoff_user_id = null;
                $newLoe->save();

                if ($newLoe->first_line == 1) {
                    LoeHistory::create([
                        'project_loe_id' => $newLoe->id,
                        'user_id' => Auth::user()->id,
                        'description' => 'LoE table created from template'
                    ]);
                }

                //Duplicate all sites for this loe
                $template_loe_site = LoeSite::where('project_loe_id',$loe->id)->get();
                foreach ($template_loe_site as $key => $loe_site) {
                    $newLoeSite = $loe_site->replicate();
                    $newLoeSite->project_loe_id = $newLoe->id;
                    $newLoeSite->save();
                }

                //Duplicate all consultant for this loe
                $template_loe_cons = LoeConsultant::where('project_loe_id',$loe->id)->get();
                foreach ($template_loe_cons as $key => $loe_cons) {
                    $newLoeCons = $loe_cons->replicate();
                    $newLoeCons->project_loe_id = $newLoe->id;
                    $newLoeCons->save();
                }
            }
            
            
            $result->msg = 'LoE appended successfuly';
        } else {
            $result->result = 'error';
            $result->msg = 'The LoE you selected doesn t have records that can be imported';
        }

        return json_encode($result);
    }

    //Various Edit
    public function edit_general(Request $request)
    {
        $result = new \stdClass();
        $result->result = 'success';

        $inputs = $request->all();
        //region Error check
        $loe_to_edit = LOE::find($inputs['id']);

        if ($loe_to_edit->user_id != Auth::user()->id && !Auth::user()->can('projectLoe-editAll')) {
            $result->result = 'error';
            $result->msg = 'You cannot edit this LoE as you did not create it';
            return json_encode($result);
        }
        //Quantity and Loe per unit must be a numerical value
        if ($inputs['colname'] == 'quantity' || $inputs['colname'] == 'loe_per_quantity' || $inputs['colname'] == 'fte' || $inputs['colname'] == 'num_of_months') {
            
            if (!is_numeric($inputs['value'])) {
                $result->result = 'error';
                $result->msg = 'Only numerical value accepted';
                return json_encode($result);
            } elseif ($inputs['value'] < 0) {
                $result->result = 'error';
                $result->msg = 'Must be positive';
                return json_encode($result);
            }

            //FTE must be between 0 and 1. We already checked above that this is numeric and non negative
            if ($inputs['colname'] == 'fte' && $inputs['value'] > 1) {
                $result->result = 'error';
                $result->msg = 'Must be between 0 and 1';
                return json_encode($result);
            }
        }
        //endregion


        $loe = LOE::find($inputs['id']);
        $loe_old_value = $loe[$inputs['colname']];
        $loe->update([$inputs['colname'] => $inputs['value']]);

        //Working on saving to history
        if ($inputs['colname'] == 'quantity' || $inputs['colname'] == 'loe_per_quantity' || $inputs['colname'] == 'fte' || $inputs['colname'] == 'num_of_months' || $inputs['colname'] == 'recurrent') {
            if ($loe_old_value != $inputs['value']) {
                LoeHistory::create([
                    'project_loe_id' => $loe->id,
                    'user_id' => Auth::user()->id,
                    'description' => 'Value modified',
                    'field_modified' => $inputs['colname'],
                    'field_old_value' => $loe_old_value,
                    'field_new_value' => $inputs['value'],
                ]);
            }
        }

        return json_encode($result);
    }

    public function edit_consulting(Request $request)
    {
        $result = new \stdClass();
        $result->result = 'success';

        $inputs = $request->all();
        //region Error check
        $loe_cons = LoeConsultant::find($inputs['id']);
        $loe_to_edit = LOE::find($loe_cons->project_loe_id);

        if ($loe_to_edit->user_id != Auth::user()->id && !Auth::user()->can('projectLoe-editAll')) {
            $result->result = 'error';
            $result->msg = 'You cannot edit this LoE as you did not create it';
            return json_encode($result);
        }
        //Value must be a numerical value
        if (!is_numeric($inputs['value'])) {
            $result->result = 'error';
            $result->msg = 'Only numerical value accepted';
            return json_encode($result);
        } elseif ($inputs['value'] < 0) {
            $result->result = 'error';
            $result->msg = 'Must be positive';
            return json_encode($result);
        }
        //endregion


        $loe_cons = LoeConsultant::find($inputs['id']);
        $loe_cons_old_value = $loe_cons[$inputs['colname']];
        $loe_cons->update([$inputs['colname'] => $inputs['value']]);

        //Working on saving to history
        if ($inputs['colname'] == 'price' || $inputs['colname'] == 'cost' || $inputs['colname'] == 'percentage') {
            if ($loe_cons_old_value != $inputs['value']) {
                LoeHistory::create([
                    'project_loe_id' => $loe_cons->project_loe_id,
                    'user_id' => Auth::user()->id,
                    'description' => 'Consulting ('.$loe_cons->name.') value modified',
                    'field_modified' => $inputs['colname'],
                    'field_old_value' => $loe_cons_old_value,
                    'field_new_value' => $inputs['value'],
                ]);
            }
        }

        return json_encode($result);
    }

    public function edit_site(Request $request)
    {
        $result = new \stdClass();
        $result->result = 'success';

        $inputs = $request->all();

        //We have 2 cases: First one is the formula and second one is the site information
        if ($inputs['colname'] == 'formula') {
            //FORMULA
            //region Error check
            $loe_to_edit = LOE::find($inputs['id']);

            if ($loe_to_edit->user_id != Auth::user()->id && !Auth::user()->can('projectLoe-editAll')) {
                $result->result = 'error';
                $result->msg = 'You cannot edit this LoE as you did not create it';
                return json_encode($result);
            }
            //endregion
            //First we need to get all data from site table associated to this formula
            $old_formula = $inputs['value'];
            $new_formula = $inputs['value'];
            $loe_id = $inputs['id'];
            $loe = LOE::find($loe_id);
        } else {
            //SITE INFO
            //region Error check
            $loe_site = LoeSite::find($inputs['id']);
            $loe_to_edit = LOE::find($loe_site->project_loe_id);

            if ($loe_to_edit->user_id != Auth::user()->id && !Auth::user()->can('projectLoe-editAll')) {
                $result->result = 'error';
                $result->msg = 'You cannot edit this LoE as you did not create it';
                return json_encode($result);
            }
            //Value must be a numerical value
            if (!is_numeric($inputs['value'])) {
                $result->result = 'error';
                $result->msg = 'Only numerical value accepted';
                return json_encode($result);
            } elseif ($inputs['value'] < 0) {
                $result->result = 'error';
                $result->msg = 'Must be positive';
                return json_encode($result);
            }
            //endregion
            $loe_site = LoeSite::find($inputs['id']);
            $loe_id = $loe_site->project_loe_id;
            $loe = LOE::find($loe_id);
            $old_formula = $loe->formula;
            $new_formula = $loe->formula;
            $loe_site->update([$inputs['colname'] => $inputs['value']]);
        }

        $loe_per_quantity_old_value = $loe->loe_per_quantity;

        if (empty($new_formula)) {
            $loe->update(['formula' => null,'loe_per_quantity' => 0]);
            $result->new_loe_per_quantity = 0;
        } else {
            //Now we need to calculate the new information with the formula and verify it doesn't get an error
            $site_data = LoeSite::where('project_loe_id',$loe_id)->get();
            foreach ($site_data as $key => $data) {
                $product = $data->quantity*$data->loe_per_quantity;
                $new_formula = str_replace("{{".$data->name."}}",$product,$new_formula);
            }
            $alphanum = preg_match("/^(-?[0-9.]+[\+\-\*\/])+[0-9.]+$|-?[0-9.]+/",$new_formula);
            
            if ($alphanum == 0) {
                $result->result = 'error';
                $result->msg = 'There is a problem with your formula: '.$old_formula;
                return json_encode($result);
            } else {
                $executor = new MathExecutor();
                // If division by 0 then equals 0
                $new_loe_per_quantity = $executor->setDivisionByZeroIsZero()->execute($new_formula);
                if ($new_loe_per_quantity < 0) {
                    $result->result = 'error';
                    $result->msg = 'The formula returns a negative value';
                    return json_encode($result);
                } else {
                    $loe->update(['formula' => $old_formula,'loe_per_quantity' => $new_loe_per_quantity]);
                    $result->new_loe_per_quantity = $new_loe_per_quantity;
                }
            }
        }

        //Working on saving to history
        if ($loe_per_quantity_old_value != $new_loe_per_quantity) {
            LoeHistory::create([
                'project_loe_id' => $loe->id,
                'user_id' => Auth::user()->id,
                'description' => 'Calculation',
                'field_modified' => 'LoE per quantity',
                'field_old_value' => $loe_per_quantity_old_value,
                'field_new_value' => $new_loe_per_quantity,
            ]);
        }
        
        return json_encode($result);
    }

    public function edit_row_order(Request $request)
    {
        $result = new \stdClass();
        $result->result = 'success';

        $inputs = $request->all();
        
        $this->reorder($inputs['id'],$inputs['new_position']);
        $result->msg = 'Order changed successfully';

        return json_encode($result);
    }
    //endregion

}

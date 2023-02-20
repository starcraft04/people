<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Loe;
use App\User;
use App\Activity;

use App\LoeHistory;
use App\LoeSite;
use App\LoeConsultant;
use NXP\MathExecutor;
use App\Repositories\ActivityRepository;
use App\Http\Controllers\Auth\AuthUsersForDataView;
use App\Customer;
use Datatables;
use App\Project;
use App\ConsultingPricing;

class LoeController extends Controller
{
    //region LoE general
    public function __construct(ActivityRepository $activityRepository)
    {
        $this->activityRepository = $activityRepository;
        
    }

    public function view($id)
    {
        $project = Project::find($id);
        $customer = Customer::find($project->customer_id);
        $usersX  = User::pluck('name', 'id');

        $customers_list = Customer::leftjoin('projects','projects.customer_id','=','customers.id')
        ->leftjoin('project_loe','project_loe.project_id','=','projects.id')
        ->whereNotNull('project_loe.id')
        ->pluck('customers.name', 'customers.id');
        return view('loe/create_update', compact('project','customer','customers_list','usersX'));
    }


 




public function buildList(Request $request)
    {
        $sumCost = [];
        $sumPrice = [];
        $margin =  [];
        $output = "";
        $all = DB::table('project_loe as pl')
        ->join('project_loe_consultant as plc','pl.id','=','plc.project_loe_id')
        ->join('projects as p','pl.project_id','=','p.id')
        ->join('customers as c','p.customer_id','c.id')
        ->select(
        DB::raw('SUM(case when location in ("Netherlands","Germany","Switzerland","United Kingdom","Russia","Belgium") then percentage ELSE 0 END) as on_percent'),

//on shore cost
        DB::raw('SUM(case when plc.location IN ("Netherlands","Germany","Switzerland","United Kingdom","Russia","Belgium") then ((pl.quantity*plc.percentage*pl.loe_per_quantity*plc.cost)/100) ELSE 0 END)  as on_cost'),
// on shore price
        DB::raw('SUM(case when plc.location IN ("Netherlands","Germany","Switzerland","United Kingdom","Russia","Belgium") then ((pl.quantity*plc.percentage*pl.loe_per_quantity*plc.price)/100) ELSE 0 END)as on_price'),

        DB::raw('SUM(case when location in ("Egypt","India") then percentage ELSE 0 END) as off_percentage'),
//off shore cost
        DB::raw('SUM(case when plc.location IN ("Egypt","India") then ((pl.quantity*plc.percentage*pl.loe_per_quantity*plc.price)/100) Else 0 END) as off_price'),
//off shore price
        DB::raw('SUM(case when plc.location IN ("Egypt","India") then ((pl.quantity*plc.percentage*pl.loe_per_quantity*plc.cost)/100) Else 0 END) as off_cost'),

    DB::raw('SUM(case when location in ("Poland","Romania") then percentage ELSE 0 END) as near_percentage'),
//near shore price
    DB::raw('SUM(case when plc.location IN ("poland","Romania") then ((pl.quantity*plc.percentage*pl.loe_per_quantity*plc.price)/100) Else 0 END) as near_price'),
//near shore cost
    DB::raw('SUM(case when plc.location IN ("poland","Romania") then ((pl.quantity*plc.percentage*pl.loe_per_quantity*plc.cost)/100) Else 0 END) as near_cost'),
        'c.name','p.id','pl.id as plID', 'p.project_name','pl.main_phase','pl.quantity','plc.percentage as unit_percent', 'plc.location','plc.price as unit_price','plc.cost as unit_cost','plc.seniority','pl.loe_per_quantity')
        ->where('p.project_name','LIKE','%'.$request->search.'%')
        ->where('pl.main_phase','LIKE','%'.$request->search_phase.'%')
        ->where('c.name','LIKE','%'.$request->search_customer.'%')
        ->groupBy('plc.project_loe_id')
        ->orderBy('p.id','DESC')
        ->get();


        $check = DB::table('project_loe as pl')
        ->join('project_loe_consultant as plc','pl.id','=','plc.project_loe_id')
        ->join('projects as p','pl.project_id','=','p.id')
        ->join('customers as c','p.customer_id','c.id')
        ->select('pl.id','plc.id as plcID','pl.loe_per_quantity','pl.quantity as quantity','plc.cost','plc.percentage','plc.price','plc.location','plc.name','plc.seniority')
        ->where('p.project_name','LIKE','%'.$request->search.'%')
        ->where('pl.main_phase','LIKE','%'.$request->search_phase.'%')
        ->get();

        $not_empty = [];

        foreach($check as $key)
        {
            if(!empty($key->location) || !empty($key->seniority))
            {
                array_push($not_empty,$key);
            }
        }

        

       foreach($check as $cKey)
        {
             foreach($not_empty as $nKey)
            {
                if(empty($cKey->location) && $nKey->name == $cKey->name)
                {
                    $cKey->location = $nKey->location;
                }
                elseif (empty($cKey->seniority) && $nKey->name == $cKey->name) {
                    // code...
                    $cKey->seniority = $nKey->seniority;
                }
            }

        }


        foreach($check as $sumVals)
        {
            if(isset($sumPrice[$sumVals->id]) && isset($sumCost[$sumVals->id]))
                {
                  
                  $sumPrice[$sumVals->id] += round(((($sumVals->quantity*$sumVals->percentage*$sumVals->loe_per_quantity)/100)*$sumVals->price));
                  
                  $sumCost[$sumVals->id] += round(((($sumVals->quantity*$sumVals->percentage*$sumVals->loe_per_quantity)/100)*$sumVals->cost));

                   if($sumCost[$sumVals->id] == 0)
                  {
                    $margin[$sumVals->id] = 0;
                  }
                  else{
                    $margin[$sumVals->id] = round((100*($sumPrice[$sumVals->id] -$sumPrice[$sumVals->id])/$sumCost[$sumVals->id]));
                  }

                }
                else if(!isset($sumPrice[$sumVals->id]) && !isset($sumCost[$sumVals->id])){
                  $sumPrice[$sumVals->id]=0;
                  $sumCost[$sumVals->id]=0;
                  $sumPrice[$sumVals->id] += round(((($sumVals->quantity*$sumVals->percentage*$sumVals->loe_per_quantity)/100)*$sumVals->price));
                  
                  $sumCost[$sumVals->id] += round(((($sumVals->quantity*$sumVals->percentage*$sumVals->loe_per_quantity)/100)*$sumVals->cost));
                  
                  if($sumCost[$sumVals->id] == 0)
                  {
                    $margin[$sumVals->id] = 0;
                  }
                  else{
                    $margin[$sumVals->id] = round((100*($sumPrice[$sumVals->id] -$sumPrice[$sumVals->id])/$sumCost[$sumVals->id]));
                  }

                }
        }



        foreach($check as $checkKey)
        {
            $records = DB::table('project_loe_consultant')
            ->where('id',$checkKey->plcID)
            ->update(['location'=>$checkKey->location,'seniority'=>$checkKey->seniority]);
        }



        foreach($all as $key)
        {
            $total = $key->unit_cost;
            $total_off_shore_cost = 0;
            $total_on_shore_cost = 0;
            $total_near_shore_cost =0;
            //echo $total;
            
            //off shore total cost and price with MD
            $off_shore_MD = (($key->quantity * $key->off_percentage * $key->loe_per_quantity)/100);
            $total_off_shore_cost += $off_shore_MD * $key->unit_cost;
            $total_off_shore_price = $off_shore_MD * $key->off_price;

            //on shore total cost and price with MD
            $on_shore_MD = (($key->quantity * $key->on_percent * $key->loe_per_quantity)/100);
            $total_on_shore_cost += $on_shore_MD * $key->unit_cost;
            $total_on_shore_price =$on_shore_MD * $key->on_price;


            //near shore total cost and price with MD
            $near_shore_MD = (($key->quantity * $key->near_percentage * $key->loe_per_quantity)/100);
            $total_near_shore_cost += $near_shore_MD * $key->unit_cost;
            $total_near_shore_price = $near_shore_MD * $key->near_price;


            $total_price = $total_off_shore_price+$total_on_shore_price+$total_near_shore_price;

            $total_cost = $total_off_shore_cost+$total_on_shore_cost+$total_near_shore_cost;

            $output.=
            '<tr id ='.$key->id.'>
             <td>'.$key->id.'</td>
              <td>'.$key->plID.'</td>
              <td>'.$key->name.'</td>
             <td>'.$key->project_name.'</td>
             <td>'.$key->main_phase.'</td>
             <td>'.$key->quantity.'</td>
             <td>'.$key->loe_per_quantity.'</td>
             <td>'.round($key->off_percentage,1).'</td>
             <td>'.round($off_shore_MD,2).'</td>
             <td>'.round($key->off_cost,1).'</td>
             <td>'.round($key->off_price,1).'</td>
             <td>'.round($key->on_percent,1).'</td>
             <td>'.round($on_shore_MD,2).'</td>
             <td>'.round($key->on_cost,1).'</td>
             <td>'.round($key->on_price,1).'</td>
             <td>'.round($key->near_percentage,1).'</td>                          
             <td>'.round($near_shore_MD,2).'</td>
             <td>'.round($key->near_cost,1).'</td>
             <td>'.round($key->near_price,1).'</td>
             <td id="total_loe">'.round($key->quantity*$key->loe_per_quantity,1).'</td>';



            foreach($margin as $id => $val)
              {

              if($id == $key->plID)
              {
              
                $output.='<td id="margin">'.$val.'</td>';
               
              }
              }
              
             foreach($sumCost as $id => $val)
              {
                if($id == $key->plID)
              {
                $output.='<td id="total_cost">'.$val.'</td>';
              }
             
              }
             foreach($sumPrice as $id => $val)
              {
                if($id == $key->plID)
              {
                $output.='<td id="total_price">'.$val.'</td>';
              }
              }
             
              
             
             
            $output.='</tr>';

        } 

        

        
        

        return $output;
    }
    
    public function list()
    {
        $on_shore=[];
        $off_shore=[];
        $near_shore=[];

        

$all = DB::table('project_loe as pl')
        ->join('project_loe_consultant as plc','pl.id','=','plc.project_loe_id')
        ->join('projects as p','pl.project_id','=','p.id')
        ->join('customers as c','p.customer_id','c.id')
        ->select(
DB::raw('SUM(case when location in ("Netherlands","Germany","Switzerland","United Kingdom","Russia","Belgium") then percentage ELSE 0 END) as on_percent'),

//on shore cost
DB::raw('SUM(case when plc.location IN ("Netherlands","Germany","Switzerland","United Kingdom","Russia","Belgium") then ((pl.quantity*plc.percentage*pl.loe_per_quantity*plc.cost)/100) ELSE 0 END)  as on_cost'),
// on shore price
DB::raw('SUM(case when plc.location IN ("Netherlands","Germany","Switzerland","United Kingdom","Russia","Belgium") then ((pl.quantity*plc.percentage*pl.loe_per_quantity*plc.price)/100) ELSE 0 END)as on_price'),

DB::raw('SUM(case when location in ("Egypt","India") then percentage ELSE 0 END) as off_percentage'),
//off shore cost
DB::raw('SUM(case when plc.location IN ("Egypt","India") then ((pl.quantity*plc.percentage*pl.loe_per_quantity*plc.price)/100) Else 0 END) as off_price'),
//off shore price
DB::raw('SUM(case when plc.location IN ("Egypt","India") then ((pl.quantity*plc.percentage*pl.loe_per_quantity*plc.cost)/100) Else 0 END) as off_cost'),

DB::raw('SUM(case when location in ("Poland","Romania") then percentage ELSE 0 END) as near_percentage'),
//near shore price
DB::raw('SUM(case when plc.location IN ("poland","Romania") then ((pl.quantity*plc.percentage*pl.loe_per_quantity*plc.price)/100) Else 0 END) as near_price'),
//near shore cost
DB::raw('SUM(case when plc.location IN ("poland","Romania") then ((pl.quantity*plc.percentage*pl.loe_per_quantity*plc.cost)/100) Else 0 END) as near_cost'),
'c.name','p.id','pl.id as plID', 'p.project_name','pl.main_phase','pl.quantity','plc.percentage as unit_percent', 'plc.location','plc.price as unit_price','plc.cost as unit_cost','plc.seniority','pl.loe_per_quantity')
        ->groupBy('plc.project_loe_id')
        ->orderBy('p.id','DESC')
        ->get();


//1574,1370,100
        
        $check = DB::table('project_loe as pl')
        ->join('project_loe_consultant as plc','pl.id','=','plc.project_loe_id')
        ->join('projects as p','pl.project_id','=','p.id')
        ->join('customers as c','p.customer_id','c.id')
        ->select('pl.id','plc.id as plcID','pl.loe_per_quantity','pl.quantity','plc.cost','plc.percentage','plc.price','plc.location','plc.name','plc.seniority')
        ->get();

        $not_empty = [];

        foreach($check as $key)
        {
            if(!empty($key->location) || !empty($key->seniority))
            {
                array_push($not_empty,$key);
            }
        }
//         SELECT p.id,plc.id,plc.id, plc.location FROM project_loe as pl INNER JOIN project_loe_consultant as plc on pl.id = plc.project_loe_id INNER JOIN projects as p on p.id = pl.project_id 
// where p.id = 1719
        // $record =DB::table('project_loe as pl')
        //                 ->join('project_loe_consultant as plc','pl.id','=','plc.project_loe_id')
        //                 ->join('projects as p','pl.project_id','=','p.id')
        //                 ->join('customers as c','p.customer_id','c.id')
        //                 ->where('plc.name',$cKey->name)
        //                 ->update(['plc.location'=>$nKey->location]);
        

       foreach($check as $cKey)
        {
             foreach($not_empty as $nKey)
            {
                if(empty($cKey->location) && $nKey->name == $cKey->name)
                {
                    $cKey->location = $nKey->location;
                }
                elseif (empty($cKey->seniority) && $nKey->name == $cKey->name) {
                    // code...
                    $cKey->seniority = $nKey->seniority;
                }
            }

        }

        foreach($check as $checkKey)
        {
            $records = DB::table('project_loe_consultant')
            ->where('id',$checkKey->plcID)
            ->update(['location'=>$checkKey->location,'seniority'=>$checkKey->seniority]);
        }

   
        return view('loe/list', compact('all','check'));
    }

    public function getLoePerProject($project_id)
    {
        $data = DB::table('project_loe as pl')
        ->join('project_loe_consultant as plc','pl.id','=','plc.project_loe_id')
        ->join('projects as p','pl.project_id','=','p.id')
        ->select('plc.location as location','plc.cost as cost','plc.price as price')
        ->where('p.id',$project_id)
        ->groupBy('plc.location')
        ->get();

        return $data;
    }






// LOE by Totals

    public function listAllLoe()
    {

// select p.id, p.project_name,
// (select SUM(quantity) from project_loe where project_id = p.id group by project_id) as quantity,
// (select SUM(loe_per_quantity) from project_loe where project_id = p.id group by project_id) as loe_per_quantity,
// SUM(CASE when plc.location in ("Egypt","India") then ((pl.quantity*plc.percentage*pl.loe_per_quantity)/100) ELSE 0 END)  as off_MD,
// SUM(CASE when plc.location in ("Egypt","India") then ((pl.quantity*plc.percentage*pl.loe_per_quantity*plc.cost)/100) ELSE 0 END)  as off_cost,
// SUM(CASE when plc.location in ("Egypt","India") then ((pl.quantity*plc.percentage*pl.loe_per_quantity*plc.price)/100) ELSE 0 END)  as off_price,
// SUM(CASE when plc.location in ("Netherlands","Germany","Switzerland","United Kingdom","Russia","Belgium") then ((pl.quantity*plc.percentage*pl.loe_per_quantity)/100) ELSE 0 END)  as on_MD,
// SUM(CASE when plc.location in ("Netherlands","Germany","Switzerland","United Kingdom","Russia","Belgium") then ((pl.quantity*plc.percentage*pl.loe_per_quantity*plc.cost)/100) ELSE 0 END)  as on_cost,
// SUM(CASE when plc.location in ("Netherlands","Germany","Switzerland","United Kingdom","Russia","Belgium") then ((pl.quantity*plc.percentage*pl.loe_per_quantity*plc.price)/100) ELSE 0 END)  as on_price,
// SUM(CASE when plc.location in ("poland","Romania") then ((pl.quantity*plc.percentage*pl.loe_per_quantity)/100) ELSE 0 END)  as near_MD,
// SUM(CASE when plc.location in ("poland","Romania") then ((pl.quantity*plc.percentage*pl.loe_per_quantity*plc.cost)/100) ELSE 0 END)  as near_cost,
// SUM(CASE when plc.location in ("poland","Romania") then ((pl.quantity*plc.percentage*pl.loe_per_quantity*plc.price)/100) ELSE 0 END)  as near_price
// from project_loe as pl INNER JOIN project_loe_consultant as plc on pl.id = plc.project_loe_id INNER JOIN projects as p on pl.project_id = p.id
// WHERE p.id in (1,1808,1807,1760)
// group by p.id

        $all = DB::table('project_loe as pl')
        ->join('project_loe_consultant as plc','pl.id','=','plc.project_loe_id')
        ->join('projects as p','pl.project_id','=','p.id')
        ->join('customers as c','p.customer_id','c.id')
        ->select(
            'p.id', 'p.project_name','c.name as customer_name',
            DB::raw('(select SUM(quantity) from project_loe where project_id = p.id group by project_id) as quantity'),
            DB::raw('(select SUM(loe_per_quantity) from project_loe where project_id = p.id group by project_id) as loe_per_quantity'),
            DB::raw('SUM(CASE when plc.location in ("Egypt","India") then ((pl.quantity*plc.percentage*pl.loe_per_quantity)/100) ELSE 0 END)  as off_MD'),
            DB::raw('SUM(CASE when plc.location in ("Egypt","India") then ((pl.quantity*plc.percentage*pl.loe_per_quantity*plc.cost)/100) ELSE 0 END)  as off_cost'),
            DB::raw('SUM(CASE when plc.location in ("Egypt","India") then ((pl.quantity*plc.percentage*pl.loe_per_quantity*plc.price)/100) ELSE 0 END)  as off_price'),
            DB::raw('SUM(CASE when plc.location in ("Netherlands","Germany","Switzerland","United Kingdom","Russia","Belgium") then ((pl.quantity*plc.percentage*pl.loe_per_quantity)/100) ELSE 0 END)  as on_MD'),
            DB::raw('SUM(CASE when plc.location in ("Netherlands","Germany","Switzerland","United Kingdom","Russia","Belgium") then ((pl.quantity*plc.percentage*pl.loe_per_quantity*plc.cost)/100) ELSE 0 END)  as on_cost'),
            DB::raw('SUM(CASE when plc.location in ("Netherlands","Germany","Switzerland","United Kingdom","Russia","Belgium") then ((pl.quantity*plc.percentage*pl.loe_per_quantity*plc.price)/100) ELSE 0 END)  as on_price'),
            DB::raw('SUM(CASE when plc.location in ("poland","Romania") then ((pl.quantity*plc.percentage*pl.loe_per_quantity)/100) ELSE 0 END)  as near_MD'),
            DB::raw('SUM(CASE when plc.location in ("poland","Romania") then ((pl.quantity*plc.percentage*pl.loe_per_quantity*plc.cost)/100) ELSE 0 END)  as near_cost'),
            DB::raw('SUM(CASE when plc.location in ("poland","Romania") then ((pl.quantity*plc.percentage*pl.loe_per_quantity*plc.price)/100) ELSE 0 END)  as near_price',)
        )
        ->groupBy('p.id')
        ->orderBy('p.id','DESC')
        ->get();
        $output='';

        foreach($all as $key)
        {
            $output.=
            '<tr id ='.$key->id.'>
             <td style="display:none">'.$key->id.'</td>
              <td style="display:none">--</td>
              <td>'.$key->customer_name.'</td>
             <td>'.$key->project_name.'</td>
             <td>--</td>
             <td>'.$key->quantity.'</td>
             <td>'.$key->loe_per_quantity.'</td>
             <td>--</td>
             <td>'.round($key->off_MD,1).'</td>
             <td>'.round($key->off_cost,1).'</td>
             <td>'.round($key->off_price,1).'</td>
             <td>--</td>
             <td>'.round($key->on_MD,1).'</td>
             <td>'.round($key->on_cost,1).'</td>
             <td>'.round($key->on_price,1).'</td>
             <td>--</td>                          
             <td>'.round($key->near_MD,1).'</td>
             <td>'.round($key->near_cost,1).'</td>
             <td>'.round($key->near_price,1).'</td>
             <td>'.round($key->loe_per_quantity,1).'</td>
             <td>--</td>
             <td>'.round(($key->off_cost)+($key->on_cost)+($key->near_cost),1).'</td>
             <td>'.round(($key->off_price)+($key->on_price)+($key->near_price),1).'</td>
             <tr>';
        }





        return $output;
 
    }

    // public function addSudoUsersToProject($id)
    // {
        
    //     var_dump($project_practice);
    // }

    public function addFTEtoZZZuser()
    {
        /* project id , zzz user id, start-date, end-date,
        differenece
        for($i=st;$i<=diff;$i++)
        {
            Activity::updateOrCreate(
                ['project_id' => $id,
                'user_id' => $zzz_user_id],
                [
                'year' => '2023',
                'month' => $i,
                'task_hour' => 17,
                'from_otl' => 0,
                ]);
        }
        */
    }
    public function init($id)
    {
        
        $project_practice = Project::where('id',$id)->get('project_practice');

        if($project_practice[0]->project_practice == 'SC')
        {
            $zzz_user_name = 'ZZZ_Security_and_Compliance';
        }

        if($project_practice[0]->project_practice == 'IOT')
        {
            $zzz_user_name = 'ZZZ_IoT_and_Edge';
        }
        if($project_practice[0]->project_practice == 'CX')
        {
            $zzz_user_name = 'ZZZ_Customer_Experience';
        }
        if($project_practice[0]->project_practice == 'PMO')
        {
            $zzz_user_name = 'ZZZ_Project_Management_Office';
        }
        
        if($project_practice[0]->project_practice == 'ITPA')
        {
            $zzz_user_name = 'ZZZ_IT_Performance_and_Assurace';
        }
        if($project_practice[0]->project_practice == 'CN')
        {
            $zzz_user_name = 'ZZZ_Cloud_Networking';
        }
        if($project_practice[0]->project_practice == 'CDD')
        {
            $zzz_user_name = 'ZZZ_Cloud_and_Data_Digitalization';
        }
        if($project_practice[0]->project_practice == 'MGT')
        {
            $zzz_user_name = 'ZZZ_Management';
        }
        
        $zzz_user_id_query = User::where('name',$zzz_user_name)->get('id');
        $zzz_user_id = $zzz_user_id_query[0]->id;
        
        for($i=1;$i<13;$i++){

        $inputsActivities = [
          'year' => '2023',
          'month' => $i,
          'project_id' => $id,
          'user_id' => $zzz_user_id,
          'task_hour' => 0,
          'from_otl' => 0,
        ];
                $activity = $this->activityRepository->create($inputsActivities);
        }
        $result = new \stdClass();
        $inputs = [
            'project_id' => $id,
            'user_id' => Auth::user()->id,
            'quantity' => 1,
            'loe_per_quantity' => 0,
            'first_line' => 1
        ];
        $get_different_cons_typeert_result = Loe::create($inputs);
        if ($get_different_cons_typeert_result != null) {
            LoeHistory::create([
                'project_loe_id' => $get_different_cons_typeert_result->id,
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

    public function getStatusConsName(Request $request, $id)
    {
        $request = $request->all();
        $m="";
        $column_name = $request['colname'];
        $results = array();
        $loe_data = Loe::where('project_id',$id)
                    ->orderBy('row_order','asc')
                    ->orderBy('main_phase','asc')
                    ->orderBy('secondary_phase','asc')
                    ->orderBy('domain','asc')
                    ->orderBy('description','asc')
                    ->get();
        $userX = User::pluck('id','name');


        foreach($loe_data as $key => $value)
        {

                 $m= '<td data-colname="'.$column_name.'" style="min-width:220px;" contenteditable="false"><select class="form-control select2" id="assigned_user_id" data-placeholder="Select a user"><option></option></select></td>';  
            
        }
        
        return $m;
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
            // Domaget_different_cons_type
            $domaget_different_cons_type = [];
            foreach ($loe_data as $key => $domain) {
                if (!in_array($domain->domain, $domaget_different_cons_type)){
                    array_push($domaget_different_cons_type,$domain->domain);
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
            $results['col']['domaget_different_cons_type'] = $domaget_different_cons_type;
            $results['data'] = array();
            $results['data']['loe'] = $loe_data;
            $results['data']['site'] = $data_sites_formatted;
            $results['data']['cons'] = $data_consultants_formatted;
        }
        return $results;
    }


    public function listFromProjectIDRow($id,$row)
    {
        $results = array();
        $loe_data = Loe::where(array(['project_id'=>$id],['row_order'=>$row]))
                    ->orderBy('main_phase','asc')
                    ->orderBy('secondary_phase','asc')
                    ->orderBy('domain','asc')
                    ->orderBy('description','asc')
                    ->get();

        if (count($loe_data) > 0) {
            // Domaget_different_cons_type
            $domaget_different_cons_type = [];
            foreach ($loe_data as $key => $domain) {
                if (!in_array($domain->domain, $domaget_different_cons_type)){
                    array_push($domaget_different_cons_type,$domain->domain);
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
            $results['col']['domaget_different_cons_type'] = $domaget_different_cons_type;
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
                ->select('projects.id','projects.project_name','project_loe.domain','project_loe.project_id')
                ->where('projects.customer_id', $id)
                ->whereNotNull('project_loe.id')
                ->groupBy('projects.id')
                ->get();

        return json_encode($project_list);
    }
     public function dashboardProjectsDomain($id)
    {
        $domain_list = LOE::select('id','row_order','domain','main_phase')->where('project_id','=',$id)->groupBy('domain')->get()->toArray();

        return json_encode($domain_list);
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

            LoeConsultant::join('project_loe','project_loe_consultant.project_loe_id','=','project_loe.id')->where('project_loe.project_id',$inputs['project_id'])->where('project_loe_consultant.name',$inputs['name'])->update(['price'=>$pricing->unit_price,'cost'=>$pricing->unit_cost]);
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
        // It will then get_different_cons_typeert the record at the new_row_order and move the rest of the records
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

    // public function append_template(Request $request)
    // {
    //     $result = new \stdClass();
    //     $result->result = 'success';

    //     $inputs = $request->all();

    //     $template_loe = Loe::where(array('project_id'=>$inputs['template_project_id'],'domain'=>$inputs['template_project_domain'],'row_order'=>$inputs['order']))->orderBy('row_order')->get();
        
    //     if ($template_loe->count() > 0) {

    //         // $this_loes = Loe::where('project_id',$inputs['this_project_id'])->get();
    //         //Now we need to delete all existing records for the project id
    //         // foreach ($this_loes as $key => $this_loe) {
    //         //     $this->delete($this_loe->id);
    //         // }

    //         //Now we can replicate all data from the template
    //         foreach ($template_loe as $key => $loe) {
    //             //Duplicate each loe from template
    //             $newLoe = $loe->replicate();
    //             $newLoe->project_id = $inputs['this_project_id']; // the new project_id
    //             $newLoe->row_order = ($inputs['countRow'])+1;
    //             $newLoe->user_id = Auth::user()->id;
    //             $newLoe->signoff_user_id = null;
    //             $newLoe->save();

    //             if ($newLoe->first_line == 1) {
    //                 LoeHistory::create([
    //                     'project_loe_id' => $newLoe->id,
    //                     'user_id' => Auth::user()->id,
    //                     'description' => 'LoE table created from template'
    //                 ]);
    //             }

    //             //Duplicate all sites for this loe
    //             $template_loe_site = LoeSite::where('project_loe_id',$loe->id)->get();
    //             foreach ($template_loe_site as $key => $loe_site) {
    //                 $newLoeSite = $loe_site->replicate();
    //                 $newLoeSite->project_loe_id = $newLoe->id;
    //                 $newLoeSite->save();
    //             }

    //             //Duplicate all consultant for this loe
    //             $template_loe_cons = LoeConsultant::where('project_loe_id',$loe->id)->get();



    //             foreach ($template_loe_cons as $key => $loe_cons) {
    //                 $newLoeCons = $loe_cons->replicate();
    //                 $newLoeCons->project_loe_id = $newLoe->id;
    //                 $newLoeCons->save();
    //             }
    //         }
            
            
    //         $result->msg = 'LoE appended successfuly';
    //     } else {
    //         $result->result = 'error';
    //         $result->msg = 'The LoE you selected doesn t have records that can be imported';
    //     }

    //     return json_encode($result);
    // }

    //get the same consultant types in the new project
    public function get_the_same_cons_type($a,$b){
        $get_different_cons_type = [];
        foreach ($a as $key => $valueA) {
            // code...
            foreach ($b as $key => $valueB) {
                // code...
                if($valueA->name === $valueB->name){
                    array_push($get_different_cons_type, $valueA);
                }
            }
        }
        return $get_different_cons_type;
    }


// get the different consultant types between two projects
public  function get_different_cons_type($x,$y){
     if(sizeof($x)>sizeof($y)){
        $get_different_cons_type = $x;
        for($i=0;$i<sizeof($get_different_cons_type);$i++){
        for($j=0;$j<sizeof($y);$j++){
            
                if($get_different_cons_type[$i]['name'] === $y[$j]['name']){
                array_splice($get_different_cons_type,$i,1);
                }

        }

        }
     }
     else{

        $get_different_cons_type = $y;
        for($i=0;$i<sizeof($get_different_cons_type);$i++){
        for($j=0;$j<sizeof($x);$j++){
            
                if($get_different_cons_type[$i]['name'] === $x[$j]['name']){
                array_splice($get_different_cons_type,$i,1);
                }

        }

        }

     }
    return $get_different_cons_type;
}


    public function append_template(Request $request)
    {
        $result = new \stdClass();
        $result->result = 'success';

        $inputs = $request->all();

        $template_loe = Loe::where(array('project_id'=>$inputs['template_project_id'],'domain'=>$inputs['template_project_domain']))->orderBy('row_order')->get();
        
        if ($template_loe->count() > 0) {


            // $this_loes = Loe::where('project_id',$inputs['this_project_id'])->get();
            //Now we need to delete all existing records for the project id
            // foreach ($this_loes as $key => $this_loe) {
            //     $this->delete($this_loe->id);
            // }


            //old cons 
            $old_cons = LOE::where('project_id',$inputs['this_project_id'])->get('id')->first();

            $old_cons_temp = LoeConsultant::where('project_loe_id',$old_cons->id)->get();

            $all_old_cons =LoeConsultant::where('project_loe_id',$old_cons->id)->get()->pluck('id','name');


            $old_cons_new = LOE::where('project_id',$inputs['this_project_id'])->get('id');

            $the_row_order = $inputs['countRow'];

            //Now we can replicate all data from the template
            foreach ($template_loe as $key => $loe) {
                //Duplicate each loe from template
                $newLoe = $loe->replicate();
                $newLoe->project_id = $inputs['this_project_id']; // the new project_id
                $newLoe->row_order = $the_row_order+1;
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

                //new one 
                $template_loe_cons = LoeConsultant::where('project_loe_id',$loe->id)->get();

                $same_cons_types = LoeController::get_the_same_cons_type($template_loe_cons,$old_cons_temp);
                $diff_cons_types = LoeController::get_different_cons_type($old_cons_temp->toArray(),$template_loe_cons->toArray());


            if(sizeof($old_cons_temp) == sizeof($template_loe_cons)){
                foreach ($template_loe_cons as $key => $loe_cons) {
                    $newLoeCons = $loe_cons->replicate();
                    $newLoeCons->project_loe_id = $newLoe->id;
                    $newLoeCons->save();

                }  
            }else{
                
                if(empty($same_cons_types)){
                    foreach($template_loe_cons as $key=> $val){
                        $records = LoeConsultant::create(
                            [
                        'project_loe_id'=>$newLoe->id,
                        'name'=>$val['name'],
                        'location'=>$val['location'],
                        'seniority'=>$val['seniority'],
                        'percentage'=>$val['percentage'],
                        'price'=>$val['price'],
                        'cost'=>$val['cost']
                         ]);
                     }
                foreach ($old_cons_temp as $key => $value) {
                    // code...
                    $records = LoeConsultant::create(
                            [
                        'project_loe_id'=>$newLoe->id,
                        'name'=>$value['name'],
                        'location'=>$value['location'],
                        'seniority'=>$value['seniority'],
                        'percentage'=>'0',
                        'price'=>$value['price'],
                        'cost'=>$value['cost']
                         ]);

                     }
                }else{

                foreach ($same_cons_types as $key => $value) {
                    // code...
                         $records = LoeConsultant::create(
                            [
                        'project_loe_id'=>$newLoe->id,
                        'name'=>$value['name'],
                        'location'=>$value['location'],
                        'seniority'=>$value['seniority'],
                        'percentage'=>$value['percentage'],
                        'price'=>$value['price'],
                        'cost'=>$value['cost']
                         ]);

                     }
                foreach($diff_cons_types  as $key => $val){
                        $records = LoeConsultant::create(
                            [
                        'project_loe_id'=>$newLoe->id,
                        'name'=>$val['name'],
                        'location'=>$val['location'],
                        'seniority'=>$val['seniority'],
                        'percentage'=>'0',
                        'price'=>$val['price'],
                        'cost'=>$val['cost']
                         ]);
                }   


                }


            }


            $the_row_order++;

        }



        if(sizeof($old_cons_temp) != sizeof($template_loe_cons)){

            
            if(empty($same_cons_types)){
                        foreach ($old_cons_new as $key => $value) {
            
                foreach ($template_loe_cons as $key => $newLoe) {

                            $records = LoeConsultant::create(
                            [
                        'project_loe_id'=>$value->id,
                        'name'=>$newLoe->name,
                        'location'=>$newLoe->location,
                        'seniority'=>$newLoe->seniority,
                        'percentage'=>'0',
                        'price'=>$newLoe->price,
                        'cost'=>$newLoe->cost
                         ]);
                        
                    


                                   

                 }
            // code...
            
          }
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
        // save start date and end date to get the values

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

    public function changeBevahiorOnZZZ(Request $request)
    {
        //status
        //project_id
        //user_id
        //loe_id
        //project practice

        $inputs = $request->all();

        $result = new \stdClass();
        $result->result = 'success';
        $project_id = $inputs['project_id'];
        $status = $inputs['value'];
        $project_loe_id = $inputs['id'];

        $project_cons_id = $inputs['cons_id'];

        if($status == 'Canceled' || $status == 'Deal Lost')
        {
            $behavior = Activity::where(['project_id'=>$project_id, 'user_id'=>$project_cons_id])->delete();
            $result->result = 'Activity Removed';

        }
        return json_encode($result);
    }

    public function assignConsAndZZZ(Request $request)
    {
        // required
        // project ID
        // user ID
        // get project practice 
        // get ZZZ 
        // number of months



    }
    public function AddDataToSudoUser(Request $request){   
        $result = new \stdClass();
        $result->result = 'success';

        $inputs = $request->all();
        // //region Error check
        // $loe_to_edit = LOE::find($inputs['id']);


        //add loe to the zzz user on change the start date

        $loeForZZZ = LOE::find($inputs['id']);
        $start_date = $loeForZZZ['start_date'];
        $end_date = $loeForZZZ['end_date'];
        $no_of_days = $loeForZZZ['loe_per_quantity'];
        $number_of_mons = intval($loeForZZZ['num_of_months']);
        $number_of_fte = $loeForZZZ['fte']; // for calculation, either 1 or smaller
        $time=strtotime($start_date);
        $st_month_of_zzz=intval(date("m",$time));
        $st_year_of_zzz = intval(date("Y",$time));

        $end_time=strtotime($end_date);
        $end_month_of_zzz=intval(date("m",$end_time));
        $end_year_of_zzz = intval(date("Y",$end_time));

        //number of years
        $no_of_years = $end_year_of_zzz - $st_year_of_zzz;

        //project data

        $project_id_for_zzz = $loeForZZZ['project_id'];
        $project_practice = Project::where('id',$project_id_for_zzz)->get('project_practice'); // to make Z user

        //project practice 


        if($project_practice[0]->project_practice == 'SC')
        {
            $zzz_user_name = 'ZZZ_Security_and_Compliance';
        }

        if($project_practice[0]->project_practice == 'IOT')
        {
            $zzz_user_name = 'ZZZ_IoT_and_Edge';
        }
        if($project_practice[0]->project_practice == 'CX')
        {
            $zzz_user_name = 'ZZZ_Customer_Experience';
        }
        if($project_practice[0]->project_practice == 'PMO')
        {
            $zzz_user_name = 'ZZZ_Project_Management_Office';
        }
        
        if($project_practice[0]->project_practice == 'ITPA')
        {
            $zzz_user_name = 'ZZZ_IT_Performance_and_Assurace';
        }
        if($project_practice[0]->project_practice == 'CN')
        {
            $zzz_user_name = 'ZZZ_Cloud_Networking';
        }
        if($project_practice[0]->project_practice == 'CDD')
        {
            $zzz_user_name = 'ZZZ_Cloud_and_Data_Digitalization';
        }
        if($project_practice[0]->project_practice == 'MGT')
        {
            $zzz_user_name = 'ZZZ_Management';
        }

        // $zzz_user_name = 'ZZZ_'.$project_practice[0]->project_practice;
        
        $zzz_user_id_query = User::where('name',$zzz_user_name)->get('id');
        $zzz_user_id = $zzz_user_id_query[0]->id;
        
        //
        $recurrent_for_zzz = $loeForZZZ['recurrent'];
        if($recurrent_for_zzz == 1){
            $total_task_hours = ($number_of_mons*17*$number_of_fte)/$number_of_mons;
        }
        else{
            $total_task_hours = ($no_of_days)/$number_of_mons;
        }
        $cond = [
                  'project_id' => $project_id_for_zzz,
                  'user_id' => $zzz_user_id
              ];
        $user = $loeForZZZ['cons_id'];

        if($no_of_years > 0){
            for($i=$st_month_of_zzz;$i<=12;$i++){
                if($loeForZZZ['status'] == "Assigned Not Signed" || $loeForZZZ['status'] == "Assigned and Closed"){
                    $task_exists = Activity::where(['project_id'=>$project_id_for_zzz,'user_id'=>$user
                        ,'month'=>$i, 'year'=>$st_year_of_zzz])->get('task_hour');
                    if ($task_exists->isEmpty()) {
                        $th = 0;
                    }else{$th = $task_exists[0]->task_hour;}
                    $load_hours_to_unassigned = Activity::updateOrCreate([
                        'user_id'=>$user,
                        'project_id'=>$project_id_for_zzz,
                        'month'=> $i,
                        'year'=> $st_year_of_zzz
                    ],
                        ['task_hour'=>$total_task_hours+$th]
                    );
                }
                elseif($loeForZZZ['status'] =='Onhold' || $loeForZZZ['status'] == 'Under Assignement' || $loeForZZZ['status'] == 'In Planning'){
                    if($user != ""){
                        $task_exists = Activity::where(['project_id'=>$project_id_for_zzz,'user_id'=>$user,'month'=>$i,
                            'year'=>$st_year_of_zzz])->get('task_hour');

                        $total_t_hours = Activity::where(['project_id'=>$project_id_for_zzz,'user_id'=>$zzz_user_id,'month'=>$i,
                            'year'=>$st_year_of_zzz])->get('task_hour');

                        $th = $task_exists[0]->task_hour;
                        $total_task_hours = $total_t_hours[0]->task_hour;
                    }
                    else{
                        $th =0;
                    }
                    $load_hours_to_unassigned = Activity::updateOrCreate([
                        'user_id'=>$zzz_user_id,
                        'project_id'=>$project_id_for_zzz,
                        'month'=> $i,
                        'year'=> $st_year_of_zzz
                    ],
                        ['task_hour'=>$total_task_hours+$th]
                    );
                    // will remove everything!!!
                    $remove_load = Activity::updateOrCreate([
                        'user_id'=>$user,
                        'project_id'=>$project_id_for_zzz,
                        'month'=> $i,
                        'year'=> $st_year_of_zzz
                    ],
                        ['task_hour'=>0]
                    );
                }
                // When is empty
                else{
                    $load_hours_to_unassigned = Activity::updateOrCreate([
                        'user_id'=>$zzz_user_id,
                        'project_id'=>$project_id_for_zzz,
                        'month'=> $i,
                        'year'=> $st_year_of_zzz
                    ],
                        ['task_hour'=>$total_task_hours]
                    );
                }
            }
            for($j=$end_year_of_zzz;$j>$st_year_of_zzz;$j--){
                if($j == $end_year_of_zzz){
                    for($k=1;$k<=$end_month_of_zzz;$k++){
                        if($loeForZZZ['status'] == "Assigned Not Signed" || $loeForZZZ['status'] == "Assigned and Closed"){
                            $task_exists = Activity::where(['project_id'=>$project_id_for_zzz,'user_id'=>$user
                                ,'month'=>$k, 'year'=>$j])->get('task_hour');
                            if ($task_exists->isEmpty()) {
                                $th = 0;
                            }
                            else{$th = $task_exists[0]->task_hour;}
                            $load_hours_to_unassigned = Activity::updateOrCreate([
                                'user_id'=>$user,
                                'project_id'=>$project_id_for_zzz,
                                'month'=> $k,
                                'year'=> $j
                            ],
                                ['task_hour'=>$total_task_hours+$th]
                            );
                        }
                        elseif($loeForZZZ['status'] =='Onhold' || $loeForZZZ['status'] == 'Under Assignement' || $loeForZZZ['status'] == 'In Planning'){
                            if($user != ""){
                                $task_exists = Activity::where(['project_id'=>$project_id_for_zzz,'user_id'=>$user
                                    ,'month'=>$k, 'year'=>$j])->get('task_hour');

                                $total_t_hours = Activity::where(['project_id'=>$project_id_for_zzz,'user_id'=>$zzz_user_id
                                    ,'month'=>$k, 'year'=>$j])->get('task_hour');

                                $total_task_hours = $total_t_hours[0]->task_hour;
                                $th = $task_exists[0]->task_hour;
                            }
                            else{
                                $th =0;
                            }
                            $load_hours_to_unassigned = Activity::updateOrCreate([
                                'user_id'=>$zzz_user_id,
                                'project_id'=>$project_id_for_zzz,
                                'month'=> $k,
                                'year'=> $j
                            ],
                                ['task_hour'=>$total_task_hours+$th]
                            );
                            // will remove everything!!!
                            $remove_load = Activity::updateOrCreate([
                                'user_id'=>$user,
                                'project_id'=>$project_id_for_zzz,
                                'month'=> $k,
                                'year'=> $j
                            ],
                                ['task_hour'=>0]
                            );
                        }
                        // When is empty
                        else{
                            $load_hours_to_unassigned = Activity::updateOrCreate([
                                'user_id'=>$zzz_user_id,
                                'project_id'=>$project_id_for_zzz,
                                'month'=> $k,
                                'year'=> $j
                            ],
                                ['task_hour'=>$total_task_hours]
                            );
                        }                                
                    }
                }
                else{
                    for($k=1;$k<=12;$k++){
                        if($loeForZZZ['status'] == "Assigned Not Signed" || $loeForZZZ['status'] == "Assigned and Closed"){
                            $task_exists = Activity::where(['project_id'=>$project_id_for_zzz,'user_id'=>$user
                                ,'month'=>$k, 'year'=>$j])->get('task_hour');
                            if ($task_exists->isEmpty()) {
                                $th = 0;
                            }else{$th = $task_exists[0]->task_hour;}
                            $load_hours_to_unassigned = Activity::updateOrCreate([
                                'user_id'=>$user,
                                'project_id'=>$project_id_for_zzz,
                                'month'=> $k,
                                'year'=> $j
                            ],
                                ['task_hour'=>$total_task_hours+$th]
                            );
                        }
                        elseif($loeForZZZ['status'] =='Onhold' || $loeForZZZ['status'] == 'Under Assignement' || $loeForZZZ['status'] == 'In Planning'){
                            if($user != " "){
                                $task_exists = Activity::where(['project_id'=>$project_id_for_zzz,'user_id'=>$user,'month'=>$k,
                                    'year'=>$j])->get('task_hour');

                                $total_t_hours = Activity::where(['project_id'=>$project_id_for_zzz,'user_id'=>$zzz_user_id
                                    ,'month'=>$k, 'year'=>$j])->get('task_hour');
                                $total_task_hours = $total_t_hours[0]->task_hour;

                                $th = $task_exists[0]->task_hour;
                            }
                            else{
                                $th =0;
                            }
                            $load_hours_to_unassigned = Activity::updateOrCreate([
                                'user_id'=>$zzz_user_id,
                                'project_id'=>$project_id_for_zzz,
                                'month'=> $k,
                                'year'=> $j
                            ],
                                ['task_hour'=>$total_task_hours+$th]
                            );
                            $remove_load = Activity::updateOrCreate([
                                'user_id'=>$user,
                                'project_id'=>$project_id_for_zzz,
                                'month'=> $k,
                                'year'=> $j
                            ],
                                ['task_hour'=>0]
                            );
                        }
                        // When is empty
                        else{
                            $load_hours_to_unassigned = Activity::updateOrCreate([
                                'user_id'=>$zzz_user_id,
                                'project_id'=>$project_id_for_zzz,
                                'month'=> $k,
                                'year'=> $j
                            ],
                                ['task_hour'=>$total_task_hours]
                            );
                        }
                    }
                }
            }  
        }
        else{
            $count = 0;
            for($i=$st_month_of_zzz;$i<=$end_month_of_zzz;$i++)
                {
                    $count++;
                    if($loeForZZZ['status'] == "Assigned Not Signed" || $loeForZZZ['status'] == "Assigned and Closed")    
                    {
                        $task_exists = Activity::where(['project_id'=>$project_id_for_zzz,'user_id'=>$zzz_user_id,'month'=>$i, 'year'=>$st_year_of_zzz])->get('task_hour');
                    
                    
                        $th = $task_exists[0]->task_hour;
                    $load_hours_to_unassigned = Activity::updateOrCreate([
                    'user_id'=>$user,
                    'project_id'=>$project_id_for_zzz,
                    'month'=> $i,
                    'year'=> $st_year_of_zzz
                ],
                ['task_hour'=>($total_task_hours)]
                );
                    }
                    elseif($loeForZZZ['status'] =='Onhold' || $loeForZZZ == 'Under Assignement' || $loeForZZZ == 'In Planning')    
                    {
                       if($user != "")
                        {
                            $task_exists = Activity::where(['project_id'=>$project_id_for_zzz,'user_id'=>$user,'month'=>$i, 'year'=>$st_year_of_zzz])->get('task_hour');

                            $total_t_hours = Activity::where(['project_id'=>$project_id_for_zzz,'user_id'=>$zzz_user_id
                                    ,'month'=>$i, 'year'=>$st_year_of_zzz])->get('task_hour');


                            $total_task_hours = $total_t_hours[0]->task_hour;

                            $th = $task_exists[0]->task_hour;
                        }
                        else{
                            $th =0;
                        }
                            $remove_load = Activity::updateOrCreate
                                                    ([
                                                    'user_id'=>$user,
                                                    'project_id'=>$project_id_for_zzz,
                                                    'month'=> $i,
                                                    'year'=> $st_year_of_zzz
                                                ],
                                                ['task_hour'=>0]
                                                );
                            $load_hours_to_unassigned = Activity::updateOrCreate
                                                    ([
                                                    'user_id'=>$zzz_user_id,
                                                    'project_id'=>$project_id_for_zzz,
                                                    'month'=> $i,
                                                    'year'=> $st_year_of_zzz
                                                ],
                                                ['task_hour'=>$total_task_hours+$th]
                                                );
                            
                        }
                    else{
                        // return $task_exists;

                    $task_exists = Activity::where(['project_id'=>$project_id_for_zzz,'user_id'=>$zzz_user_id,'month'=>$i, 'year'=>$st_year_of_zzz])->get('task_hour');
                    
                    
                    $th = $task_exists[0]->task_hour;
                    $load_hours_to_unassigned = Activity::updateOrCreate(
                [
                    'user_id'=>$zzz_user_id,
                    'project_id'=>$project_id_for_zzz,
                    'month'=> $i,
                    'year'=> $st_year_of_zzz
                ],
                ['task_hour'=>($total_task_hours+$th)]
                );
                    }
                    
                } 
                
         }   
        return json_encode($user);
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

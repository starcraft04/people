<?php


//bupa 16816

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Datatables;
use App\Project;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use App\Imports\CLImport;



class ClController extends Controller
{
    //
    public function CustomerLink()
    {
        return view('dataFeed/sambainfo');
    }


    public function projectsWithoutCLID(Request $request)
    {
        $inputs = $request->all();
        $year = $inputs['year'];

        $projectsWithoutCLID = DB::table('projects as p')
        ->join('activities as a','p.id','=','a.project_id')
        ->select('p.project_name','a.project_id','p.samba_id')
        ->where('a.year','=',$year)
        ->whereNull('p.samba_id')
        ->groupBy('a.project_id')
        ->get();

        $data = Datatables::of($projectsWithoutCLID)->make(true);

        return $data;



    }
    public function callCL(Request $request)
    {
        $inputs = $request->all();
        $year = $inputs['year'];
        $has_samba_id =[];
        $has_no_samba_id=[];

        $data = DB::table('projects as p')
        ->join('activities as a','p.id','=','a.project_id')
        ->select('p.project_name','a.project_id','p.samba_id')
        ->where('a.year','=',$year)
        ->groupBy('a.project_id')
        ->get();

        foreach($data as $key => $value){
            if($value->samba_id != null){

                array_push($has_samba_id, $value->samba_id);

            }
            else{
                array_push($has_no_samba_id,$value->samba_id);
            }
        
        }




        $client = new \GuzzleHttp\Client([
        'headers' => [
          'Content-Type' => 'application/json',
          'Connection'=>'keep-alive',
          "X-XSS-Protection"=> 0,

        ]
    ]);

    //     $request = $client->post('https://test.salesforce.com/services/oauth2/token',
    //     [ 
    //         'form_params'=>[
    //             'grant_type' => 'password',
    //             'client_id' => '3MVG9GXbtnGKjXe4G0a3YKZse5kKU1D0x_WTlBPIR0XO2mmFxMv3CVF44NqI6LbNL0J0Le5HWUdA8b6uUCSL_',
    //             'client_secret' => '1EBA1B7C71E505303076D6064D54F7A8B99CFE8FEFE9F9C44DCC74C9948AB5C3',
    //             'username' => 'itf-dolphin@orange.com.uat',
    //             'password' => 'God_help2End',
    //             'security_token'=>'0IG1G8L1cZOrrosGAXzZlgVi',
    //         ],

    //     ]);

    //     $response = json_decode($request->getBody());    


        
    //     $access_token = $response->access_token;
        //70169070
        $headers = [
            'Authorization' => 'Bearer 00D1q0000004aco!AR0AQNkjH_TUIXSDeinqeY3LsFpN_LsBgxAB3sY80zCDOwN6GADKT.RwOUc5qjumcJ_lee5hhDbGO48VW4YNNc8Oxr.BiiBX' ,        
            'Accept'        => 'application/json',
        ];

$uri = "https://samba--uat.my.salesforce.com/services/data/v52.0/query?q=SELECT+SMB_OwnerSalesCluster__c,Account_Name__c,SMB_OPP_Domains__c,Name,SMB_OPP_Public_Opportunity_ID__c,Opportunity_18_ID__c,Owner.Name,CreatedDate,CloseDate,StageName,Probability,Amount,(SELECT+Product2.Name,TotalPrice+FROM+OpportunityLineItems)+FROM+Opportunity+WHERE+SMB_OPP_Public_Opportunity_ID__c+IN+('".implode("','",$has_samba_id)."')";
        // $str=str_replace("\n","",$uri);



         $getRequest = $client->request('GET',$uri,
        [ 
            'headers' => $headers,
            

        ]);

        $opp = json_decode($getRequest->getBody());

        $projects_by_year = DB::table('projects as p')
        ->join('activities as a','p.id','=','a.project_id')
        ->select('p.project_name','a.project_id','p.samba_id','p.samba_18_id')
        ->where('a.year','=',$year)
        ->whereNotNull('samba_id')
        ->groupBy('p.id')
        ->get();

        $opp_with_id = [];
        
        

           foreach($opp->records as $opp_key){
                // code...

                $update = Project::where('samba_id',$opp_key->SMB_OPP_Public_Opportunity_ID__c)->Update([
                    'samba_18_id' => $opp_key->Opportunity_18_ID__c,
                    'samba_opportunit_owner'=>$opp_key->Owner->Name,
                    'samba_lead_domain'=>$opp_key->SMB_OPP_Domains__c,
                    'samba_stage'=>$opp_key->StageName,
                    'estimated_start_date'=>$opp_key->CreatedDate,
                    'estimated_end_date'=>$opp_key->CloseDate,
                    'win_ratio'=>$opp_key->Probability
                    ]);

            }
        return $update;

         


    }

     public function UploadExcelToAddCLID(Request $request)

    {
        $file = $request->file;
        $customer_link_file = Excel::toArray(new CLImport, $file);

        $clf = $customer_link_file[0];

         $project_id        ='';
         $project_name      ='';
         $customer_link_id  ='';
         
         
        

         for($i=0;$i<sizeof($clf);$i++)
        {
            $project_id           = $clf[$i]['project_id'];
            $project_name         = $clf[$i]['project_name'];
            $customer_link_id     = $clf[$i]['customer_link_id'];
            
            //  Update Project Customer Link ID
            $existing_samba_id = [];
            $customer_link_update =
            [
                'samba_id' => $customer_link_id,
                
            ];
            $project_id_exists = Project::where('id', $project_id)->first();
            $project_id_exists_in = $project_id_exists->id;

          
            if($project_id_exists->samba_id != Null)
            {
                
                Project::where('id',$project_id_exists_in)->update($customer_link_update);

            }
            else{

                array_push($existing_samba_id,$project_id_exists_in);

            }


        }
        return redirect('customerLinks')->with('success', 'Record Updated successfully')->compact('existing_samba_id');
    }

}

<?php

namespace App\Http\Controllers;

use App\Cluster;
use Illuminate\Http\Request;
use App\Repositories\ClusterRepository;
use App\Http\Requests;
use App\Http\Requests\ClusterCreateRequest;
use App\Http\Requests\ClusterUpdateRequest;
use App\Country;
use Entrust;

class ClusterController extends Controller
{
    //
    protected $clusterRepository;

  public function __construct(ClusterRepository $clusterRepository)
  {
    $this->clusterRepository = $clusterRepository;
	}

    public function getList()
	{
		return view('cluster/list');
	}

	public function ListOfClusters()
 	 {
    	return $this->clusterRepository->getListOfClusters();
	  }

  	public function show($id)
	{
    $cluster = Cluster::find($id);
		return view('cluster/show',  compact('cluster'));
	}

	public function getFormUpdate($id)
	{
    $cluster = Cluster::find($id);

    $clusterCountries = $cluster->countries->lists('country')->toArray();

		return view('cluster/create_update', compact('cluster','clusterCountries'))->with('action','update');
	}

	public function postFormUpdate(ClusterUpdateRequest $request, $id)
	{
    $inputs = $request->all();
	Country::where('cluster_id',$inputs['cluster_id'])->delete();
    foreach ($inputs['countries'] as $country) {
		Country::create([
			'cluster_id' => $inputs['cluster_id'],
			'country' => $country
		]
		);
	}

    return redirect('clusterList')->with('success','Record updated successfully');
	}

	public function getFormCreate()
	{

		return view('cluster/create_update')->with('action','create');
	}


	public function postFormCreate(ClusterCreateRequest $request)
	{
    $inputs = $request->all();
    //dd($inputs);
    $cluster = $this->clusterRepository->create($inputs);
    return redirect('clusterList')->with('success','Record created successfully');
	}



	public function delete($id)
	{
    // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
    $result = new \stdClass();

    $cluster = Cluster::find($id);

    if (count($cluster->users)){
			$result->result = 'error';
			$result->msg = 'Record cannot be deleted because some users are associated to it.';
			return json_encode($result);
		}

    Cluster::destroy($id);

    $result->result = 'success';
    $result->msg = 'Record deleted successfully';

		return json_encode($result);
	}

}

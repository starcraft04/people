<?php

namespace App\Repositories;

use App\Cluster;
use App\Country;
use Datatables;
use DB;
use Entrust;
use Auth;

class ClusterRepository
{

  protected $cluster;

  public function __construct(Cluster $cluster)
  {
    $this->cluster = $cluster;
  }

  public function create(Array $inputs)
  {
    $cluster = new $this->cluster;
    return $this->save($cluster, $inputs);
  }

    private function save(Cluster $cluster, Array $inputs)
  {
    // Required fields
    if (isset($inputs['name'])) {$cluster->name = $inputs['name'];}
    $cluster->save();

    // Now we need to save the countires
    if (isset($inputs['countries'])) {
      $cluster->countries()->delete();

      foreach ($inputs['countries'] as $country) {
        $cluster->countries()->save(new Country(['country'=>$country]));
      }
    }
    else {
      $cluster->countries()->delete();
    }

    return $cluster;
  }
  

  public function getListOfClusters()
  {
    
    $clusterList = DB::table('clusters')->select( 'clusters.id', 'clusters.name');
    $data = Datatables::of($clusterList)->make(true);
    return $data;
  }

  public function getClustersList()
  {
    $data = $this->cluster->all();
    return $data;
  }

  public function getUserCluster($id)
  {
    $data = $this->cluster->where('user_id', '=', $id)->get();
    return $data;
  }

}

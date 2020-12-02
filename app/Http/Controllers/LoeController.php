<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Loe;
use App\LoeHistory;
use App\LoeSite;
use App\LoeConsultant;

class LoeController extends Controller
{
    public function listFromProjectID($id)
    {
        $results = array();
        $loe_data = Loe::where('project_id',$id)->get();

        if (count($loe_data) > 0) {
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
            $col_cons->select('consultant.name','consultant.location','consultant.seniority','consultant.price');
            $col_cons->join('project_loe_consultant AS consultant', 'project_loe.id', '=', 'consultant.project_loe_id');
            $col_cons->where('project_id',$id);
            $col_cons->groupBy('consultant.name');
            $col_cons->orderBy('consultant.name','asc');
            $data_col_cons = $col_cons->get();

            // Sites
            $sites = DB::table('project_loe');
            $sites->select('site.id','site.project_loe_id','site.name','site.quantity','site.loe_per_quantity');
            $sites->join('project_loe_site AS site', 'project_loe.id', '=', 'site.project_loe_id');
            $sites->where('project_id',$id);
            $data_sites = $sites->get();

                // Format for easy use
            $data_sites_formatted = array();
            foreach ($data_sites as $key => $row) {
                if (empty($data_formatted[$row->project_loe_id])) {
                    $data_sites_formatted[$row->project_loe_id] = array();
                }
                $data_sites_formatted[$row->project_loe_id][$row->name]['id'] = $row->id;
                $data_sites_formatted[$row->project_loe_id][$row->name]['quantity'] = $row->quantity;
                $data_sites_formatted[$row->project_loe_id][$row->name]['loe_per_quantity'] = $row->loe_per_quantity;
            }

            // Consultants
            $consultants = DB::table('project_loe');
            $consultants->select('consultant.id','consultant.project_loe_id','consultant.name','consultant.percentage');
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
            }

            
            $results['col'] = array();
            $results['col']['site'] = $data_col_sites;
            $results['col']['cons'] = $data_col_cons;
            $results['data'] = array();
            $results['data']['loe'] = $loe_data;
            $results['data']['site'] = $data_sites_formatted;
            $results['data']['cons'] = $data_consultants_formatted;
        }
        return $results;
    }

    public function listColSitesFromProjectID($id)
    {
        $result = DB::table('project_loe');
        $result->select('site.name');
        $result->join('project_loe_site AS site', 'project_loe.id', '=', 'site.project_loe_id');
        $result->where('project_id',$id);
        $result->groupBy('site.name');
        $result->orderBy('site.name','asc');
        $data = $result->get();
        return $data;
    }

    public function listColConsFromProjectID($id)
    {
        $result = DB::table('project_loe');
        $result->select('consultant.name','consultant.location','consultant.seniority','consultant.price');
        $result->join('project_loe_consultant AS consultant', 'project_loe.id', '=', 'consultant.project_loe_id');
        $result->where('project_id',$id);
        $result->groupBy('consultant.name');
        $result->orderBy('consultant.name','asc');
        $data = $result->get();
        return $data;
    }

    public function listSitesFromProjectID($id)
    {
        $result = DB::table('project_loe');
        $result->select('site.id','site.project_loe_id','site.name','site.quantity','site.loe_per_quantity');
        $result->join('project_loe_site AS site', 'project_loe.id', '=', 'site.project_loe_id');
        $result->where('project_id',$id);
        $data = $result->get();

        // Format for easy use
        $data_formatted = array();
        foreach ($data as $key => $row) {
            if (empty($data_formatted[$row->project_loe_id])) {
                $data_formatted[$row->project_loe_id] = array();
            }
            $data_formatted[$row->project_loe_id][$row->name]['id'] = $row->id;
            $data_formatted[$row->project_loe_id][$row->name]['quantity'] = $row->quantity;
            $data_formatted[$row->project_loe_id][$row->name]['loe_per_quantity'] = $row->loe_per_quantity;
        }
        
        return $data_formatted;
    }

    public function listConsFromProjectID($id)
    {
        $result = DB::table('project_loe');
        $result->select('consultant.id','consultant.project_loe_id','consultant.name','consultant.percentage');
        $result->join('project_loe_consultant AS consultant', 'project_loe.id', '=', 'consultant.project_loe_id');
        $result->where('project_id',$id);
        $result->orderBy('consultant.name','asc');
        $data = $result->get();

        // Format for easy use
        $data_formatted = array();
        foreach ($data as $key => $row) {
            if (empty($data_formatted[$row->project_loe_id])) {
                $data_formatted[$row->project_loe_id] = array();
            }
            $data_formatted[$row->project_loe_id][$row->name]['id'] = $row->id;
            $data_formatted[$row->project_loe_id][$row->name]['percentage'] = $row->percentage;
        }
        return $data_formatted;
    }

}

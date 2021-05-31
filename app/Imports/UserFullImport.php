<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class UserFullImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            //
            'email' => $row('Email'),
            'name'  => $row('Name'),
            'pimsid'=> $row('PIMS ID'),
            'ftid'  => $row('FT ID'),
            'region'=> $row('Region'),
            'country'=>$row('Country'),
            'management_code'=>$row('Management Code'),
            'is_manager'=>$row('Is Manager'),
            'employee_type'=>$row('Type')
        ]);
    }
}

<?php

namespace App\Imports;


use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class UsersImport implements ToModel,WithHeadingRow
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    
    public function model(array $row)
    {
        return new User([
            //
            'name'=>$row['name'],
            'email'=>$row['email'],
            'ftid' =>$row['ftid'],
            'pimsid' =>$row['pimsid']
        ]);
    }

   
}

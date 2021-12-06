<?php

namespace App\Imports;

use App\Models\College;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CollegesImport implements ToModel,withHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new College([
            'vcode' => $row['vcode'],
            'code' => $row['code'],
            'name' => $row['name'],
            'phone' => $row['phone'],
            'email' => $row['email'],
            'website' => $row['website'],
            'vcode' => $row['vcode'],
        ]);
    }
}

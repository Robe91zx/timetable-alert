<?php

namespace App\Imports;

use App\Models\Faculty;
use App\Http\Requests\StoreFaculty;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class FacultiesImport implements ToModel,withHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Faculty([
            'vcode' => $row['vcode'],
            'code' => $row['code'],
            'name' => $row['name'],
            'website' => $row['website'],
            'email' => $row['email'],
            'phone' => $row['phone']
        ]);
    }
}

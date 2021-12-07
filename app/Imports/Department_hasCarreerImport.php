<?php

namespace App\Imports;

use App\Models\Department_hasCarreer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class Department_hasCarreerImport implements ToModel,withHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Department_hasCarreer([
            'department_vcode' => $row['department_vcode'],
            'carreer_vcode' => $row['carreer_vcode'],
        ]);
    }
}

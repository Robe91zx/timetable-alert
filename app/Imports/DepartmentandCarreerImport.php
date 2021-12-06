<?php

namespace App\Imports;

use App\Models\DepartmentCarreer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DepartmentandCarreerImport implements ToModel,withHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new DepartmentCarreer([
            'department_vcode' => $row['department_vcode'],
            'carreer_vcode' => $row['carreer_vcode'],
        ]);
    }
}

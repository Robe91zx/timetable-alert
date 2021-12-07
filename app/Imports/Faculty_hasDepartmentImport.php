<?php

namespace App\Imports;

use App\Models\Faculty_hasDepartment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Faculty_hasDepartmentImport implements ToModel,withHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Faculty_hasDepartment([
            'faculty_vcode' => $row['faculty_vcode'],
            'department_vcode' => $row['department_vcode'],
        ]);
    }
}

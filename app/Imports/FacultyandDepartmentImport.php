<?php

namespace App\Imports;

use App\Models\FacultyDepartment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FacultyandDepartmentImport implements ToModel,withHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new FacultyDepartment([
            'faculty_vcode' => $row['faculty_vcode'],
            'department_vcode' => $row['department_vcode'],
        ]);
    }
}

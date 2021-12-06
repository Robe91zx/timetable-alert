<?php

namespace App\Imports;

use App\Models\FacultyCollege;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FacultyandCollegeImport implements ToModel,withHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new FacultyCollege([
            'faculty_vcode' => $row['faculty_vcode'],
            'college_vcode' => $row['college_vcode'],
        ]);   
    }
}

<?php

namespace App\Imports;

use App\Models\Faculty_hasCollege;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Faculty_hasCollegeImport implements ToModel,withHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Faculty_hasCollege([
            'faculty_vcode' => $row['faculty_vcode'],
            'college_vcode' => $row['college_vcode'],
        ]);
    }
}

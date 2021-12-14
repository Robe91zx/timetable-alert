<?php

namespace App\Imports;

use App\Models\Subject;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubjectImport implements ToModel,withHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Subject([
            'vcode' => $row['vcode'],
            'code' => $row['code'],
            'name' => $row['name'],
            'semester' => $row['semester'],
            'hours' => $row['hours'],
            'faculty_vcode' => $row['faculty_vcode'],
            'state' => $row['state']
        ]);
    }
}

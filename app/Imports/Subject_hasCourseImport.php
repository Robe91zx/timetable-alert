<?php

namespace App\Imports;

use App\Models\Subject_hasCourse;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Subject_hasCourseImport implements ToModel,withHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Subject_hasCourse([
            'subject_vcode' => $row['subject_vcode'],
            'course_vcode' => $row['course_vcode'],
        ]);
    }
}

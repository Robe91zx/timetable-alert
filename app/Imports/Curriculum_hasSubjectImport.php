<?php

namespace App\Imports;

use App\Models\Curriculum_hasSubject;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Curriculum_hasSubjectImport implements ToModel,withHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Curriculum_hasSubject([
            'curriculum_vcode' => $row['curriculum_vcode'],
            'subject_vcode' => $row['subject_vcode'],  
        ]);
    }
}

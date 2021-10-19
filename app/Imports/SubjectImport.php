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
            'name' => $row['name'],
            'semester' => $row['semester'],
            'department' => $row['department'],
            'total_hour' => $row['total_hour'],
            'requisite' => $row['requisite'],
            'state' => $row['state'],
            'workshop' => $row['workshop'],
            'laboratory' => $row['laboratory'],
            'equivalence' => $row['equivalence'],
            'curriculum_id' => $row['curriculum_id']
        ]);
    }
}

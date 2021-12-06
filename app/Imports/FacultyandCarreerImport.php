<?php

namespace App\Imports;

use App\Models\FacultyCarreer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FacultyandCarreerImport implements ToModel,withHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new FacultyCarreer([
            'faculty_vcode' => $row['faculty_vcode'],
            'carreer_vcode' => $row['carreer_vcode'],
        ]);
    }
}

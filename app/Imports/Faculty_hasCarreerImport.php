<?php

namespace App\Imports;

use App\Models\Faculty_hasCarreer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class Faculty_hasCarreerImport implements ToModel,withHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Faculty_hasCarreer([
            'faculty_vcode' => $row['faculty_vcode'],
            'carreer_vcode' => $row['carreer_vcode'],
        ]);
    }
}

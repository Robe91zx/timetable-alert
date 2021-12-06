<?php

namespace App\Imports;

use App\Models\CollegeCarreer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class CollegeandCarreerImport implements ToModel,withHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CollegeCarreer([
            'college_vcode' => $row['college_vcode'],
            'carreer_vcode' => $row['carreer_vcode'],
        ]);
    }
}

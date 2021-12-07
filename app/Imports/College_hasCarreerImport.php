<?php

namespace App\Imports;

use App\Models\College_hasCarreer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class College_hasCarreerImport implements ToModel,withHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new College_hasCarreer([
            'college_vcode' => $row['college_vcode'],
            'carreer_vcode' => $row['carreer_vcode'],
        ]);
    }
}

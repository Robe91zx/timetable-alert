<?php

namespace App\Imports;

use App\Models\Curriculum;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CurriculumsImport implements ToModel,withHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Curriculum([
            'vcode' => $row['vcode'],
            'code' => $row['code'],
            'name' => $row['name'],
            'description' => $row['description'],
            'duration' => $row['duration'],
            'carreer_vcode' => $row['carreer_vcode'],
            'state' => $row['state'],
        ]);
    }
}

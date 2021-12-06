<?php

namespace App\Exports;

use App\Models\CollegeCarreer;
use Maatwebsite\Excel\Concerns\FromCollection;

class CollegeandCarreerExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CollegeCarreer::all();
    }
}

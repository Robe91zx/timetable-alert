<?php

namespace App\Exports;

use App\Models\Carreer;
use Maatwebsite\Excel\Concerns\FromCollection;

class CarreersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Carreer::all();
    }
}

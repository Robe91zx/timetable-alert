<?php

namespace App\Exports;

use App\Models\Subject_hasCourse;
use Maatwebsite\Excel\Concerns\FromCollection;

class Subject_hasCourseExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Subject_hasCourse::all();
    }
}

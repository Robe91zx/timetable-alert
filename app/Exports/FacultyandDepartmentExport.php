<?php

namespace App\Exports;

use App\Models\FacultyDepartment;
use Maatwebsite\Excel\Concerns\FromCollection;

class FacultyandDepartmentExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return FacultyDepartment::all();
    }
}

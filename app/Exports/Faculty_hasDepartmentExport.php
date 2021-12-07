<?php

namespace App\Exports;

use App\Models\Faculty_has_Department;
use Maatwebsite\Excel\Concerns\FromCollection;

class Faculty_has_DepartmentExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Faculty_has_Department::all();
    }
}

<?php

namespace App\Exports;

use App\Models\Curriculum_hasSubject;
use Maatwebsite\Excel\Concerns\FromCollection;

class Curriculum_hasSubjectExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Curriculum_hasSubject::all();
    }
}

<?php

namespace App\Exports;

use App\Models\CP\Creative_park;
use Maatwebsite\Excel\Concerns\FromCollection;
use Spatie\Permission\Models\Permission;

class StudentExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Creative_park::select('student_id','name', 'email', 'phone', 'phone_2', 'batch', 'section', 'gender', 'blood')->get();
    }
}

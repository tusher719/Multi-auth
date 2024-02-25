<?php

namespace App\Imports;

use App\Models\CP\Creative_park;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToCollection
{
    /**
    * @param Collection $collection, WithHeadingRow
    */
    public function collection(Collection $rows)
    {
        //
        foreach ($rows as $row)
        {
            Creative_park::create([
                'student_id'    => $row['0'],
                'name'          => $row['1'],
                'email'         => $row['2'],
                'phone'         => $row['3'],
                'phone_2'       => $row['4'],
                'batch'         => $row['5'],
                'section'       => $row['6'],
                'gender'        => $row['7'],
//                'date'        => $row['8'],
                'blood'         => $row['8'],
            ]);
        }
    }
}

<?php

namespace App\Exports;

use App\Models\Email;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmailExport implements WithHeadings, FromCollection
{

     function __construct() {
     }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'Number',
            'Name',
            'Email',
        ];
    }

    public function collection()
    {
        return Email::all();
    }
}
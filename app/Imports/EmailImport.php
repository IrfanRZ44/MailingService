<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;

class EmailImport implements ToModel
{
    private $rows = 0;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        ++$this->rows;

        return;
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }
}

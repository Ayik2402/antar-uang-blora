<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DaftarBankImport implements ToCollection
{
    public function collection(Collection $collection)
    {
        return $collection;
    }

    public function startCell(): string
    {
        return 'A1';
    }
}

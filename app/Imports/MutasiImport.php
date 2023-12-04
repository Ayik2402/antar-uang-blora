<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MutasiImport implements ToCollection
{
    public function collection(Collection $collection)
    {
        return $collection;
    }

    public function startCell(): string
    {
        return 'A2';
    }
}

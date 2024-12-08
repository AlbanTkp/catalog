<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\Importable;


class ProductsImport implements SkipsEmptyRows
{
    use Importable;
}

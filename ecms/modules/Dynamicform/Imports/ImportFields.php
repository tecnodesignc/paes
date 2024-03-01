<?php

namespace Modules\Dynamicform\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ImportFields implements WithMultipleSheets
{

    public function sheets(): array
    {
        return [
           'fields' =>new FieldsSheetImport(),
        ];
    }

}

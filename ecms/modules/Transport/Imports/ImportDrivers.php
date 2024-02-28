<?php

namespace Modules\Transport\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ImportDrivers implements WithMultipleSheets
{

    public function sheets(): array
    {
        return [
           'driver' =>new DriversSheetImport(),
            'vehicles'=> new VehiclesSheetImport(),
        ];
    }

}

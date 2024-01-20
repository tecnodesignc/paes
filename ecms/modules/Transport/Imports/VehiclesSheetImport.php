<?php

namespace Modules\Transport\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Modules\Transport\Repositories\RouteRepository;
use Modules\Transport\Repositories\VehiclesRepository;

class VehiclesSheetImport implements ToCollection
{
    public function __construct()
    {

    }

    public function collection(Collection $rows)
    {
        try {
            $vehicle = app(VehiclesRepository::class);
            \DB::beginTransaction();
            foreach ($rows as $row) {
                if (!$row[0] || $row[0] === 'id') {
                    continue;
                }

                $data = [
                    'id' => $row[0],
                    'brand'=>$row[1],
                    'plate'=>strtoupper(str_replace(' ', '', $row[2])),
                    'model'=>$row[3],
                    'class'=>$row[4],
                    'imei'=>$row[5],
                    'capacity'=>$row[6],
                    'company_id'=>$row[7]

                ];
                $old= $vehicle->find($row[0]);
                if (isset($old)  && !empty($old)){
                    $vehicle->update($old,$data);
                }else{
                    $vehicle->create($data);
                }

                \DB::commit();
            }
            \Log::info('Vehicles collections import');
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);
            dd($e);
        }
    }
}

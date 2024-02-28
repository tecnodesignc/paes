<?php

namespace Modules\Transport\Imports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Modules\Transport\Jobs\ImportDriver;
use Modules\Transport\Repositories\DriverRepository;

class DriversSheetImport implements ToCollection,  WithChunkReading, ShouldQueue
{

    public function collection(Collection $rows)
    {
        $driver = app(DriverRepository::class);
        try {
            foreach ($rows as $row) {
                if (!$row[0] || $row[0] === 'first_name') {
                    continue;
                }
                $data = [
                    "driver_license" => $row[0],
                    "first_name" => $row[1],
                    "last_name" => $row[2],
                    "email" => $row[3],
                    "password" =>$row[4],
                    "phone" => $row[5],
                    "address" => $row[6],
                    "company_id"=>$row[7],
                    "is_activated" =>$row[8]
                ];
                ImportDriver::dispatch($data);
            }
            \Log::info('driver collections import');
        } catch (\Exception $e) {
            \Log::error($e);
            dd($e);
        }

    }

    public function batchSize(): int
    {
        return 400;
    }

    public function chunkSize(): int
    {
        return 100;
    }
}

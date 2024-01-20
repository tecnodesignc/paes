<?php

namespace Modules\Transport\Imports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Modules\Transport\Repositories\DriverRepository;

class DriversSheetImport implements ToCollection,  WithChunkReading, ShouldQueue
{

    public function collection(Collection $rows)
    {
        $driver = app(DriverRepository::class);
        \DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                if (!$row[0] || $row[0] === 'first_name') {
                    continue;
                }
                $companies=explode(',',$row[5]);
                $data = [
                    "driver_license" => $row[3],
                    "first_name" => $row[0],
                    "last_name" => $row[1],
                    "email" => $row[2],
                    "password" => $this->generatePassword(),
                    "roles" => [3],
                    "phone" => $row[4],
                    "companies"=>$companies,
                    "is_activated" => 1
                ];
                $driverOld=$driver->findByAttributes(['driver_license'=>$row[3]]);

                if (isset($driverOld) && !empty($driverOld)){
                    $driver->update($driverOld,$data);
                }else{
                    $driver->create($data);
                }

                \DB::commit();
            }
            \Log::info('driver collections import');
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);
            dd($e);
        }

    }

    public function batchSize(): int
    {
        return 400;
    }

    private function generatePassword($length = 12, $add_dashes = false, $available_sets = 'luds')
    {
        $sets = array();
        if (strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if (strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if (strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        if (strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%&*?/_-+';
        $all = '';
        $password = '';
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for ($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];
        $password = str_shuffle($password);
        if (!$add_dashes)
            return $password;
        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while (strlen($password) > $dash_len) {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }

    public function chunkSize(): int
    {
        return 100;
    }
}

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
                if (!$row[0] || $row[0] === 'first_name'|| $row[0] === 'driver_license') {
                    continue;
                }
                $driverOld = $driver->findByAttributes(['driver_license' => $row[0]]);
                if(isset($row[6]) && !empty($row[6])){
                    $address=explode(',',$row[6]);
                    $address=['address'=>$address[0],'city'=>$address[1]??'','state'=>$address[2]??'','country'=>$address[3]??''];
                }else{
                    $address=['address'=>'','city'=>'','state'=>'','country'=>''];
                }
                $data = [
                    "driver_license" => $row[0],
                    "first_name" => ucwords(strtolower($row[1])),
                    "last_name" => ucwords(strtolower($row[2])),
                    "email" => strtolower($row[3]),
                    "password" => $row[4] ?? $this->generatePassword(),
                    "roles" => [4],
                    "phone" => $row[5] ?? '00-00',
                    "address" => $address??'',
                    'company_id' => $row[7],
                    "is_activated" => $row[8]
                ];
                if (isset($driverOld) && !empty($driverOld)) {
                    if (!isset($row['password']) || empty($row['password'])) unset($data['password']);
                    $driver->update($driverOld, $data);
                } else {
                    $driver->create($data);
                }
                \DB::commit();
            }
            \Log::info('driver collections import');

        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);
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
}

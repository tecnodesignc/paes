<?php

namespace Modules\Transport\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Transport\Repositories\DriverRepository;

class ImportDriver implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var DriverRepository
     */
    private DriverRepository $driver;

    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($driver)
    {
        $this->driver = app('Modules\Transport\Repositories\DriverRepository');
        $this->data = $driver;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \DB::beginTransaction();
        try {
            $row=$this->data;
                $passengerOld = $this->driver->findByAttributes(['driver_license' => $row['driver_license']]);
                if(isset($row['address']) && !empty($row['address'])){
                    $address=explode(',',$row['address']);
                    $address=['address'=>$address[0],'city'=>$address[1]??'','state'=>$address[2]??'','country'=>$address[3]??''];
                }else{
                    $address=['address'=>'','city'=>'','state'=>'','country'=>''];
                }
                $data = [
                    "driver_license" => $row['driver_license'],
                    "first_name" => ucwords(strtolower($row['first_name'])),
                    "last_name" => ucwords(strtolower($row['last_name'])),
                    "email" => strtolower($row['email']),
                    "password" => $row['password']??$this->generatePassword(),
                    "roles" => [4],
                    "phone" => $row['phone'] ?? '00-00',
                    "address" => $address ,
                    'company_id'=>$row['company_id'],
                    "is_activated" => $row['is_activated']
                ];
                if (isset($passengerOld) && !empty($passengerOld)) {
                   if(!isset($row['password']) || empty($row['password'])) unset($data['password']);
                    $this->passenger->update($passengerOld, $data);
                } else {
                    $this->passenger->create($data);
                }
                \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);
        }
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

<?php

namespace Modules\Transport\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Transport\Repositories\PassengerRepository;

class ImportPassenger implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var PassengerRepository
     */
    private PassengerRepository $passenger;

    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($passengers)
    {
        $this->passenger = app('Modules\Transport\Repositories\PassengerRepository');
        $this->data = $passengers;
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
                $passengerOld = $this->passenger->findByAttributes(['identification' => $row['identification']]);
                $data = [
                    "identification" => $row['identification'],
                    "first_name" => ucwords(strtolower($row['first_name'])),
                    "last_name" => ucwords(strtolower($row['last_name'])),
                    "email" => strtolower($row['email']),
                    "password" => $this->generatePassword(),
                    "roles" => [2],
                    "phone" => $row['phone'] ?? '00-00',
                    'route_id' => $row['route_id'] ?? '1',
                    'service' => $row['service'] ?? 'N/A',
                    'company_id'=>$row['company_id'],
                    "pick_up_point" => ucwords(strtolower(preg_replace('([^A-Za-z0-9 \._\-@])', '', $row['pick_up_point'] ?? 'N/A'))),
                    "is_activated" => $row['is_activated']
                ];
                if (isset($passengerOld) && !empty($passengerOld)) {
                    unset($data['password']);
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

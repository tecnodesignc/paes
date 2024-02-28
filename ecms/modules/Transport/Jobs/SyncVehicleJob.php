<?php

namespace Modules\Transport\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Transport\Entities\Vehicles;
use Modules\Transport\Repositories\VehiclesRepository;

class SyncVehicleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var VehiclesRepository
     */
    private VehiclesRepository $vehicle;

    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($vehicles)
    {
        $this->vehicle = app('Modules\Transport\Repositories\VehiclesRepository');
        $this->data = $vehicles;
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
            $row = $this->data['vehicle'];
            $plateArray=explode(' ', $row->name);
            $plate = $plateArray[0]; //preg_replace('([^A-Za-z0-9])', '',$plateArray[0]);
            $vehicleOld = $this->vehicle->findByAttributes(['plate' => $plate]);
            $data = [
                'plate' => $plate,
                'device_id' => $row->id,
                'device' => $row,
                'company_id' => $this->data['company_id']
            ];
            if (isset($vehicleOld) && !empty($vehicleOld)) {
                $this->vehicle->update($vehicleOld, $data);
            } else {
                $this->vehicle->create($data);
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);
        }
    }
}

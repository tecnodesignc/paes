<?php

namespace Modules\Transport\Console;

use Illuminate\Console\Command;
use Modules\Apigpswox\Services\DeviceService;
use Modules\Sass\Repositories\CompanyRepository;
use Modules\Transport\Jobs\SyncVehicleJob;
use Modules\Transport\Repositories\VehiclesRepository;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SynchronizeVehicle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'transport:syc-vehicle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize vehicles from the location API';

    protected CompanyRepository $company;

    protected VehiclesRepository $vehicles;

    protected DeviceService $deviceService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CompanyRepository $company, VehiclesRepository $vehicles,  DeviceService $deviceService )
    {
        parent::__construct();

        $this->vehicles = $vehicles;
        $this->company=$company;
        $this->deviceService=$deviceService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $companies = $this->company->all();
        foreach ($companies as $company){
            \Log::info('Empresa '.$company->id);
            if (isset($company->settings->user_api_hash)){
                $devices = $this->deviceService->GetDevices(['user_api_hash' => $company->settings->user_api_hash]);
                foreach ($devices as $group){
                    if (isset($group->items) && count($group->items)){
                        foreach ($group->items as $device){
                            SyncVehicleJob::dispatch(collect(['company_id'=>$company->id,'vehicle'=>$device]));
                        }
                    }
                }

            }
\Log::info('sync Realizada');
        }
    }
}

<?php

namespace Modules\Transport\Http\Controllers;

use Illuminate\Contracts\Foundation\Application as ApplicationAlias;
use Illuminate\Contracts\View\Factory as FactoryAlias;
use Illuminate\Contracts\View\View as ViewAlias;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Maintenance\Entities\VehicleType;
use Modules\Sass\Repositories\CompanyRepository;
use Modules\Transport\Entities\BoxType;
use Modules\Transport\Entities\TransmissionType;
use Modules\Transport\Entities\Vehicles;
use Modules\Transport\Http\Requests\CreateVehiclesRequest;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Transport\Http\Requests\UpdateVehiclesRequest;
use Modules\Transport\Repositories\VehiclesRepository;

class VehiclesController extends AdminBaseController
{

    private VehiclesRepository $vehicle;

    private CompanyRepository $company;

    private VehicleType $vehicleType;

    private BoxType $boxType;
    private TransmissionType $transmissionType;

    public function __construct(VehiclesRepository $vehicle, CompanyRepository $company, VehicleType $vehicleType, BoxType $boxType,TransmissionType $transmissionType)
    {
        parent::__construct();

        $this->vehicle=$vehicle;
        $this->company = $company;
        $this->vehicleType=$vehicleType;
        $this->boxType=$boxType;
        $this->transmissionType =$transmissionType;
    }

    /**
     * Display a listing of the resource.
     * @return FactoryAlias|ViewAlias|ApplicationAlias
     */
    public function index(): FactoryAlias|ViewAlias|ApplicationAlias
    {
        $vehicles=$this->vehicle->all();
        return view('modules.transport.vehicles.index',compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     * @return FactoryAlias|ViewAlias|ApplicationAlias
     */
    public function create(): FactoryAlias|ViewAlias|ApplicationAlias
    {
        $types=$this->vehicleType->lists();
        $box_types= $this->boxType->lists();
        $transmission_types =$this->transmissionType->lists();
        return view('modules.transport.vehicles.create', compact('types','box_types','transmission_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateVehiclesRequest $request
     * @return mixed
     */
    public function store(CreateVehiclesRequest $request): mixed
    {

        $data=$request->all();

        $this->vehicle->create($data);

        return redirect()->route('transport.vehicles.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('transport::vehicles.title.vehicles')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Vehicles $vehicle
     * @return FactoryAlias|ViewAlias|ApplicationAlias
     */
    public function edit(Vehicles $vehicle): FactoryAlias|ViewAlias|ApplicationAlias
    {
        $types=$this->vehicleType->lists();
        $box_types= $this->boxType->lists();
        $transmission_types =$this->transmissionType->lists();
        return view('modules.transport.vehicles.edit', compact('vehicle','types','box_types','transmission_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Vehicles $vehicle
     * @param  UpdatePassengerRequest $request
     * @return Response
     */
    public function update(Vehicles $vehicle, UpdateVehiclesRequest $request)
    {
        $this->vehicle->update($vehicle, $request->all());

        return redirect()->route('transport.vehicles.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('transport::vehicles.title.vehicles')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Vehicles $vehicle
     * @return Response
     */
    public function destroy(Vehicles $vehicle)
    {
        $this->vehicle->destroy($vehicle);

        return redirect()->route('admin.transport.vehicles.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('transport::vehicles.title.vehicles')]));
    }

}

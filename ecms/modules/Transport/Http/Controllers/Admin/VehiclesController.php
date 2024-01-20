<?php

namespace Modules\Transport\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Transport\Entities\Vehicles;
use Modules\Transport\Http\Requests\CreateVehiclesRequest;
use Modules\Transport\Http\Requests\UpdateVehiclesRequest;
use Modules\Transport\Repositories\VehiclesRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class VehiclesController extends AdminBaseController
{
    /**
     * @var VehiclesRepository
     */
    private $vehicles;

    public function __construct(VehiclesRepository $vehicles)
    {
        parent::__construct();

        $this->vehicles = $vehicles;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$vehicles = $this->vehicles->all();

        return view('transport::admin.vehicles.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('transport::admin.vehicles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateVehiclesRequest $request
     * @return Response
     */
    public function store(CreateVehiclesRequest $request)
    {
        $this->vehicles->create($request->all());

        return redirect()->route('admin.transport.vehicles.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('transport::vehicles.title.vehicles')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Vehicles $vehicles
     * @return Response
     */
    public function edit(Vehicles $vehicles)
    {
        return view('transport::admin.vehicles.edit', compact('vehicles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Vehicles $vehicles
     * @param  UpdateVehiclesRequest $request
     * @return Response
     */
    public function update(Vehicles $vehicles, UpdateVehiclesRequest $request)
    {
        $this->vehicles->update($vehicles, $request->all());

        return redirect()->route('admin.transport.vehicles.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('transport::vehicles.title.vehicles')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Vehicles $vehicles
     * @return Response
     */
    public function destroy(Vehicles $vehicles)
    {
        $this->vehicles->destroy($vehicles);

        return redirect()->route('admin.transport.vehicles.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('transport::vehicles.title.vehicles')]));
    }
}

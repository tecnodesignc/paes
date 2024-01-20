<?php

namespace Modules\Transport\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Transport\Entities\Driver;
use Modules\Transport\Http\Requests\CreateDriverRequest;
use Modules\Transport\Http\Requests\UpdateDriverRequest;
use Modules\Transport\Repositories\DriverRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class DriverController extends AdminBaseController
{
    /**
     * @var DriverRepository
     */
    private $driver;

    public function __construct(DriverRepository $driver)
    {
        parent::__construct();

        $this->driver = $driver;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$drivers = $this->driver->all();

        return view('transport::admin.drivers.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('transport::admin.drivers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateDriverRequest $request
     * @return Response
     */
    public function store(CreateDriverRequest $request)
    {
        $this->driver->create($request->all());

        return redirect()->route('admin.transport.driver.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('transport::drivers.title.drivers')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Driver $driver
     * @return Response
     */
    public function edit(Driver $driver)
    {
        return view('transport::admin.drivers.edit', compact('driver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Driver $driver
     * @param  UpdateDriverRequest $request
     * @return Response
     */
    public function update(Driver $driver, UpdateDriverRequest $request)
    {
        $this->driver->update($driver, $request->all());

        return redirect()->route('admin.transport.driver.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('transport::drivers.title.drivers')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Driver $driver
     * @return Response
     */
    public function destroy(Driver $driver)
    {
        $this->driver->destroy($driver);

        return redirect()->route('admin.transport.driver.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('transport::drivers.title.drivers')]));
    }
}

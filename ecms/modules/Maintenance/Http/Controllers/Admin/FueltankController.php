<?php

namespace Modules\Maintenance\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Maintenance\Entities\Fueltank;
use Modules\Maintenance\Http\Requests\CreateFueltankRequest;
use Modules\Maintenance\Http\Requests\UpdateFueltankRequest;
use Modules\Maintenance\Repositories\FueltankRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class FueltankController extends AdminBaseController
{
    /**
     * @var FueltankRepository
     */
    private $fueltank;

    public function __construct(FueltankRepository $fueltank)
    {
        parent::__construct();

        $this->fueltank = $fueltank;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$fueltanks = $this->fueltank->all();

        return view('maintenance::admin.fueltanks.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('maintenance::admin.fueltanks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateFueltankRequest $request
     * @return Response
     */
    public function store(CreateFueltankRequest $request)
    {
        $this->fueltank->create($request->all());

        return redirect()->route('admin.maintenance.fueltank.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('maintenance::fueltanks.title.fueltanks')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Fueltank $fueltank
     * @return Response
     */
    public function edit(Fueltank $fueltank)
    {
        return view('maintenance::admin.fueltanks.edit', compact('fueltank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Fueltank $fueltank
     * @param  UpdateFueltankRequest $request
     * @return Response
     */
    public function update(Fueltank $fueltank, UpdateFueltankRequest $request)
    {
        $this->fueltank->update($fueltank, $request->all());

        return redirect()->route('admin.maintenance.fueltank.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('maintenance::fueltanks.title.fueltanks')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Fueltank $fueltank
     * @return Response
     */
    public function destroy(Fueltank $fueltank)
    {
        $this->fueltank->destroy($fueltank);

        return redirect()->route('admin.maintenance.fueltank.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('maintenance::fueltanks.title.fueltanks')]));
    }
}

<?php

namespace modules\Maintenance\Http\Controllers;

use Illuminate\Contracts\Foundation\Application as ApplicationAlias;
use Illuminate\Contracts\View\Factory as FactoryAlias;
use Illuminate\Contracts\View\View as ViewAlias;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Maintenance\Entities\Event;
use Modules\Maintenance\Entities\VehicleType;
use Modules\Maintenance\Http\Requests\UpdateEventRequest;
use Modules\Maintenance\Repositories\EventRepository;
use Modules\Sass\Repositories\CompanyRepository;
use Modules\Transport\Entities\BoxType;
use Modules\Transport\Entities\TransmissionType;
use Modules\Transport\Entities\Vehicles;
use Modules\Transport\Http\Requests\CreateVehiclesRequest;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Transport\Http\Requests\UpdateVehiclesRequest;
use Modules\Transport\Repositories\VehiclesRepository;

class EventController extends AdminBaseController
{

    private VehiclesRepository $vehicle;
    private EventRepository $event;

    private CompanyRepository $company;

    public function __construct(EventRepository $event, VehiclesRepository $vehicle, CompanyRepository $company)
    {
        parent::__construct();

        $this->event=$event;
        $this->company = $company;
        $this->vehicle=$vehicle;
    }

    /**
     * Display a listing of the resource.
     * @return FactoryAlias|ViewAlias|ApplicationAlias
     */
    public function index(): FactoryAlias|ViewAlias|ApplicationAlias
    {
        return view('modules.maintenance.events.index');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param Event $event
     * @return FactoryAlias|ViewAlias|ApplicationAlias
     */
    public function done(Event $event): FactoryAlias|ViewAlias|ApplicationAlias
    {
        $companies=company()->id?company()->id:companies()->map(function ($company){
            return $company->id;
        })->toArray();

        return view('modules.maintenance.events.done', compact('event','companies'));
    }
    public function update(Event $event, UpdateEventRequest $request)
    {
        $data=$request->all();
        $this->event->update($event,$data);

        return redirect()->route('maintenance.event.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('maintenance::events.title.events')]));
    }

}

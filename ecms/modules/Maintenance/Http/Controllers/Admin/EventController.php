<?php

namespace Modules\Maintenance\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Maintenance\Entities\Event;
use Modules\Maintenance\Http\Requests\CreateEventRequest;
use Modules\Maintenance\Http\Requests\UpdateEventRequest;
use Modules\Maintenance\Repositories\EventRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class EventController extends AdminBaseController
{
    /**
     * @var EventRepository
     */
    private $event;

    public function __construct(EventRepository $event)
    {
        parent::__construct();

        $this->event = $event;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$events = $this->event->all();

        return view('maintenance::admin.events.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('maintenance::admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateEventRequest $request
     * @return Response
     */
    public function store(CreateEventRequest $request)
    {
        $this->event->create($request->all());

        return redirect()->route('admin.maintenance.event.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('maintenance::events.title.events')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Event $event
     * @return Response
     */
    public function edit(Event $event)
    {
        return view('maintenance::admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Event $event
     * @param  UpdateEventRequest $request
     * @return Response
     */
    public function update(Event $event, UpdateEventRequest $request)
    {
        $this->event->update($event, $request->all());

        return redirect()->route('admin.maintenance.event.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('maintenance::events.title.events')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Event $event
     * @return Response
     */
    public function destroy(Event $event)
    {
        $this->event->destroy($event);

        return redirect()->route('admin.maintenance.event.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('maintenance::events.title.events')]));
    }
}

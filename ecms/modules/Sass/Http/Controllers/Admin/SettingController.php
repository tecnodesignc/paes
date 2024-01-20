<?php

namespace Modules\Sass\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Sass\Entities\Setting;
use Modules\Sass\Http\Requests\CreateSettingRequest;
use Modules\Sass\Http\Requests\UpdateSettingRequest;
use Modules\Sass\Repositories\SettingRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class SettingController extends AdminBaseController
{
    /**
     * @var SettingRepository
     */
    private $setting;

    public function __construct(SettingRepository $setting)
    {
        parent::__construct();

        $this->setting = $setting;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$settings = $this->setting->all();

        return view('sass::admin.settings.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('sass::admin.settings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSettingRequest $request
     * @return Response
     */
    public function store(CreateSettingRequest $request)
    {
        $this->setting->create($request->all());

        return redirect()->route('admin.sass.setting.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('sass::settings.title.settings')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Setting $setting
     * @return Response
     */
    public function edit(Setting $setting)
    {
        return view('sass::admin.settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Setting $setting
     * @param  UpdateSettingRequest $request
     * @return Response
     */
    public function update(Setting $setting, UpdateSettingRequest $request)
    {
        $this->setting->update($setting, $request->all());

        return redirect()->route('admin.sass.setting.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('sass::settings.title.settings')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Setting $setting
     * @return Response
     */
    public function destroy(Setting $setting)
    {
        $this->setting->destroy($setting);

        return redirect()->route('admin.sass.setting.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('sass::settings.title.settings')]));
    }
}

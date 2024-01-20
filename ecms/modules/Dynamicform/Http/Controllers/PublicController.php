<?php

namespace modules\Dynamicform\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Dynamicform\Http\Requests\CreateFormRequest;
use Modules\Dynamicform\Repositories\FormRepository;

class PublicController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function dashboard():Application|Factory|View
    {

        return view('modules.dynamic-form.index');
    }

}

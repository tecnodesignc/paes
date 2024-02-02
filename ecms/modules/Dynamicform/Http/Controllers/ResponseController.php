<?php

namespace modules\Dynamicform\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Dynamicform\Entities\Field;
use Modules\Dynamicform\Entities\FormResponse;
use Modules\Dynamicform\Repositories\FieldRepository;
use Modules\Dynamicform\Entities\Form;
use Modules\Dynamicform\Repositories\FormResponseRepository;

class ResponseController extends AdminBaseController
{
    private FormResponseRepository $form_response;

    public function __construct(FormResponseRepository $form_response)
    {
        parent::__construct();
        $this->form_response = $form_response;
    }

    public function index(Form $form)
    {
        return view('modules.dynamic-form.response.index', compact('form'));
    }


    /**
     * Show the form_response for editing the specified resource.
     *
     * @param Field $form_response
     * @return Application|Factory|View
     */
    public function show(Form $form, FormResponse $form_response): Application|Factory|View
    {
        return view('modules.dynamic-form.response.show', compact('form_response', 'form'));
    }


    /**
     * Download the view from responses to pdf
     * 
     * @param FormResponse $form_response
     * @return Pdf
     */
    public function downloadpdf(Form $form, FormResponse $form_response)
    {
      
    }

}

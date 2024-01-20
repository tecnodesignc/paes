<?php

namespace Modules\Sass\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Sass\Entities\Company;
use Modules\Sass\Entities\Type;
use Modules\Sass\Http\Requests\CreateCompanyRequest;
use Modules\Sass\Http\Requests\UpdateCompanyRequest;
use Modules\Sass\Repositories\CompanyRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\User\Contracts\Authentication;

class CompanyController extends AdminBaseController
{
    /**
     * @var CompanyRepository
     */
    private CompanyRepository $company;

    private Type $type;

    protected Authentication $auth;
    public function __construct(CompanyRepository $company, Type $type)
    {
        parent::__construct();

        $this->company = $company;
        $this->type = $type;
        $this->auth = app(Authentication::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $companies = $this->company->all();

        return view('modules.sass.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $types=$this->type->lists();
        return view('modules.sass.companies.create',compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCompanyRequest $request
     * @return RedirectResponse
     */
    public function store(CreateCompanyRequest $request): RedirectResponse
    {
        $this->company->create($request->all());

        return redirect()->route('sass.company.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('sass::companies.title.companies')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Company $company
     * @return Application|Factory|View
     */
    public function edit(Company $company): Application|Factory|View
    {
        $types=$this->type->lists();
        return view('modules.sass.companies.edit', compact('company','types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Company $company
     * @param  UpdateCompanyRequest $request
     * @return RedirectResponse
     */
    public function update(Company $company, UpdateCompanyRequest $request): RedirectResponse
    {
        $this->company->update($company, $request->all());

        return redirect()->route('sass.company.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('sass::companies.title.companies')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Company $company
     * @return RedirectResponse
     */
    public function destroy(Company $company): RedirectResponse
    {
        $this->company->destroy($company);

        return redirect()->route('sass.company.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('sass::companies.title.companies')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Company $company
     * @return Application|Factory|View
     */
    public function setting(Request $request): Application|Factory|View
    {
        $company_id= $request->session()->get('company');
        $company=$this->company->find($company_id);
        return view('modules.sass.profile.settings', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Company $company
     * @param  UpdateCompanyRequest $request
     * @return RedirectResponse
     */
    public function settingUpdate(UpdateCompanyRequest $request): RedirectResponse
    {

        $company_id= $request->session()->get('company');
        $company=$this->company->find($company_id);
        $this->company->update($company, $request->all());

        return redirect()->route('sass.company.settings')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('sass::companies.title.companies')]));
    }
    public function setCompany($id, Request $request): RedirectResponse
    {

        if ($id==='0'){
            $request->session()->remove('company');
            return redirect()->back();
        }
        $userCompanies= $this->auth->user()->companies->where('id',$id);

        $company=$this->company->find($id);

        if (!isset($company) || (!$this->auth->hasAccess('sass.companies.indexall') && !count($userCompanies))){
            return redirect()->back();
        }
        $request->session()->put('company',$company->id);

        return redirect()->back();
    }
}

<?php

namespace Modules\Transport\Http\Controllers;

use Illuminate\Contracts\Foundation\Application as ApplicationAlias;
use Illuminate\Contracts\View\Factory as FactoryAlias;
use Illuminate\Contracts\View\View as ViewAlias;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Sass\Repositories\CompanyRepository;
use Modules\Transport\Entities\Driver;
use Modules\Transport\Http\Requests\CreateDriverRequest;
use Modules\Transport\Http\Requests\UpdatePassengerRequest;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Transport\Imports\ImportDrivers;
use Modules\Transport\Repositories\DriverRepository;

class DriverController extends AdminBaseController
{

    private DriverRepository $driver;

    private CompanyRepository $company;

    public function __construct(DriverRepository $driver,CompanyRepository $company)
    {
        parent::__construct();

        $this->driver=$driver;
        $this->company = $company;
    }

    /**
     * Display a listing of the resource.
     * @return FactoryAlias|ViewAlias|ApplicationAlias
     */
    public function index(): FactoryAlias|ViewAlias|ApplicationAlias
    {
        $drivers=$this->driver->all();
        return view('modules.transport.drivers.index',compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     * @return FactoryAlias|ViewAlias|ApplicationAlias
     */
    public function create(): FactoryAlias|ViewAlias|ApplicationAlias
    {
        $companies=$this->company->all();
        return view('modules.transport.drivers.create',compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateDriverRequest $request
     * @return mixed
     */
    public function store(CreateDriverRequest $request): mixed
    {
        $data=$request->all();
        $data['password']=$this->generatePassword();
        $data['roles']=[3];
        $data['is_activated']= $request->input('is_activated')??0;
        $this->driver->create($data);

        return redirect()->route('transport.driver.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('transport::drivers.title.drivers')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Driver $driver
     * @return FactoryAlias|ViewAlias|ApplicationAlias
     */
    public function edit(Driver $driver): FactoryAlias|ViewAlias|ApplicationAlias
    {
        $companies=$this->company->all();
        return view('modules.transport.drivers.edit', compact('driver','companies'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return FactoryAlias|ViewAlias|ApplicationAlias
     */
    public function importView(): FactoryAlias|ViewAlias|ApplicationAlias
    {
        return view('modules.transport.drivers.import');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function import(Request $request)
    {

        $fileImport=$request->file('file');

        Excel::Import(new ImportDrivers(),$fileImport);

        return redirect()->route('transport.driver.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('transport::passengers.title.passengers')]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Driver $driver
     * @param  UpdatePassengerRequest $request
     * @return Response
     */
    public function update(Driver $driver, UpdatePassengerRequest $request)
    {
        $data=$request->all();
        $data['roles']=[3];
        if (empty($data['is_activated']))$data['is_activated']=false;
        $this->driver->update($driver, $data);

        return redirect()->route('transport.driver.index')
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

        return redirect()->route('transport.driver.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('transport::drivers.title.drivers')]));
    }
    public function generatePassword($length = 12, $add_dashes = false, $available_sets = 'luds')
    {
        $sets = array();
        if (strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if (strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if (strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        if (strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%&*?/_-+';
        $all = '';
        $password = '';
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for ($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];
        $password = str_shuffle($password);
        if (!$add_dashes)
            return $password;
        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while (strlen($password) > $dash_len) {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }
}

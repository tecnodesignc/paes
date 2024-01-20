<?php

namespace Modules\Apigpswox\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Apigpswox\Services\DeviceService;
use Modules\Apigpswox\Services\ReportService;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Menu\Repositories\MenuItemRepository;
use Modules\Page\Entities\Page;

class ReportController extends BasePublicController
{


    /**
     * @var Application
     */
    private Application $app;

    private ReportService $report;


    public function __construct(Application $app, ReportService $report)
    {
        parent::__construct();

        $this->app = $app;
        $this->report = $report;

    }


    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {

        $params = $request->query();

        $reports = $this->report->getReportData();
        dd($reports);

        return view('apigpswox::frontend.report.index', compact('reports'));
    }

    /**
     * @param $device_id
     * @param $report_id
     * @return View
     */
    public function show($device_id, $report_id): View
    {
        $report = $this->report->getReport($report_id);
        dd($report);
        return view('apigpswox::frontend.report.show', compact('report'));
    }

    public function create(Request $request)
    {

        $data = ['title' => 'string',
            'type' => 'integer',
            'format' => 'string', 'devices' => [],
            'date_from' => 'string',
            'date_to' => 'string'
        ];

        $report= $this->report->addReport($data);

        return redirect()->route('apigpswox.token.show')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('apigpswox::tokens.title.tokens')]));
    }


}

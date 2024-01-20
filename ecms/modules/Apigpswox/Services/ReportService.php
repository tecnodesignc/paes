<?php

namespace Modules\Apigpswox\Services;


use Modules\User\Repositories\UserRepository;

class ReportService extends Connection
{


    public function __construct()
    {}

    public function getReports()
    {
        $this->params();

        return $this->get('/get_reports');

    }

    public function getReportType()
    {
        $this->params();

        return $this->get('/get_reports_types');

    }


    public function getReportData()
    {
        $this->params();

        return $this->get('/add_report_data');

    }
    public function addReport($data)
    {
        $this->params();

        return $this->post($data,'/add_report');

    }

    public function generateReport($data)
    {
        $this->params();

        $reports = $this->post($data,'/add_report');

        return $reports;

    }

}

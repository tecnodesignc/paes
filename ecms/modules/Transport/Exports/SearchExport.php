<?php

namespace Modules\Transport\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SearchExport implements FromView
{

    private $tour;
    public function __construct($tour)
    {
        $this->tour=$tour;

    }

    public function view(): View
    {
        return view('modules.reports.excel.search-export', [
            'tours'=>$this->tour,
        ]);

    }
}

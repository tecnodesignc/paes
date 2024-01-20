<?php

namespace Modules\Transport\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ItineraryExport implements FromView
{
    private $itineraries;

    private $tour;
    public function __construct($tour,$itineraries)
    {
        $this->tour=$tour;
        $this->itineraries = $itineraries;

    }

    public function view(): View
    {
        return view('modules.reports.excel.itineraries-export', [
            'tour'=>$this->tour,
            'itineraries' =>  $this->itineraries,
        ]);

    }
}

<?php

namespace Modules\TraficPermit\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\TraficPermit\Exports\GenericExport;
use Modules\TraficPermit\Http\Controllers\Admin\TraficPermitReportCrudController;

class ExportController extends Controller
{
   public function export()
   {
       return Excel::download(new TraficPermitReportCrudController, 'trafficPermit.xlsx');
   }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\sale;

class ReportController extends Controller
{
    public function reports(Request $request)
    {
        $reports = (new Sale)
          ->where('sold_by', $request->user()->id)
          ->orderBy('created_at', 'desc')
          ->orderBy('type', 'desc')
          ->filter($request->only('dateFrom', 'dateTo'))->get();

        return ['reports' => $reports];
      }
}

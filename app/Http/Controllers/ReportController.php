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
          ->filter($request->only('dateFrom', 'dateTo'));

        $to_pay = (new Sale)
        ->where('sold_by', $request->user()->id)
        ->filter($request->only('dateFrom', 'dateTo'))->sum('cost');


        return ['reports' => $reports->paginate(), 'total' => $to_pay];
      }
}

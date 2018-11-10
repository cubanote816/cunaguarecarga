<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\sale;

class ReportController extends Controller
{
    public function reports(Request $request)
    {
      if ($request->seller == null)
      {
        // improve that code
        //TODO
        $reports = (new Sale)
          ->where('sold_by', $request->user()->id)
          ->orderBy('created_at', 'desc')
          ->orderBy('type', 'desc')
          ->filter($request->only('dateFrom', 'dateTo'));

          $to_pay = (new Sale)
          ->where('sold_by', $request->user()->id)
          ->filter($request->only('dateFrom', 'dateTo'))->sum('cost');

      }else{
        $reports = (new Sale)
          ->orderBy('created_at', 'desc')
          ->orderBy('type', 'desc')
          ->filter($request->only('seller', 'dateFrom', 'dateTo'));

          $to_pay = (new Sale)
          ->filter($request->only('seller', 'dateFrom', 'dateTo'))->sum('cost');
      }




        return ['reports' => $reports->paginate(), 'total_pay' => $to_pay];
      }
}

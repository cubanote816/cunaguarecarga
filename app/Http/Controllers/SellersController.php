<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contract;
use App\Sale;
use App\Http\Resources\SellersCollection;

class SellersController extends Controller
{
  public function getSellers(Request $request)
  {
      $hired_list = Contract::with('hired')
      ->where('contractor', $request->user()->id)
      ->latest();

      // if ($request->get('query')) {
      //     $hired_list->where('name', 'like', '%' . $request->get('query') . '%')
      //         ->orWhere('email', 'like', '%' . $request->get('query') . '%');
      // }

      return ['sellers' => $hired_list->paginate()];
  }

  public function getSellerDetail(Request $request)
  {
      $seller_detail = (new Sale)
          ->where('sold_by',$request->id)
          ->orderBy('created_at', 'desc')
          ->orderBy('type', 'desc')
          ->filter($request->only('dateFrom', 'dateTo'));

          $to_pay = (new Sale)
          ->where('sold_by', $request->id)
          ->filter($request->only('dateFrom', 'dateTo'))->sum('cost');

      return ['seller_detail' => $seller_detail->paginate(), 'total_pay' => $to_pay];
  }

}

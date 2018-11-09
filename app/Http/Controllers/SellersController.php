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
      $hired_list = Contract::with('hired')->where('contractor', $request->user()->id)->get();

      return ['sellers' => $hired_list];
  }

  public function getSellerDetail(Request $request)
  {
      $seller_detail = (new Sale)
          ->where('sold_by',$request->id)
          ->orderBy('created_at', 'desc')
          ->orderBy('type', 'desc')
          ->filter($request->only('dateFrom', 'dateTo'));

      return ['seller_detail' => $seller_detail->paginate()];
  }

}

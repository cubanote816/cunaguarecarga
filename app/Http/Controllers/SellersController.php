<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Contract;
use App\Http\Resources\SellersCollection;

class SellersController extends Controller
{
  public function getSeller(Request $request)
  {
      $contracted_list = User::with('owner')->where('id', $request->user()->id);
      $lists= new SellersCollection($contracted_list);
      $hired_list = Contract::with('hired')->where('contractor', $request->user()->id)->get();

      return ['sellers' => $hired_list];
  }


  public function getSellerDetail($id)
  {
//        $seller_detail = Sale::with('user')->where('sold_by',$id)->get(); // GROUP BY TODO
//
//        return ['seller_detail' => $seller_detail];

      $seller_detail = (new Sale)
          ->where('sold_by',$id)
          ->orderBy('created_at', 'desc')
          ->orderBy('type', 'desc')
          ->filter($request->only('dateFrom', 'dateTo'));

      return ['seller_detail' => $seller_detail->paginate()];
  }
}

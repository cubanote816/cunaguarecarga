<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellersController extends Controller
{
  public function getSeller(Request $request)
  {
      $contracted_list = User::with('owner')->where('id', $request->user()->id)->get();
      //$lists= new SellersCollection($contracted_list);

      return ['sellers' => $contracted_list];
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

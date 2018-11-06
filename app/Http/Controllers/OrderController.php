<?php

namespace App\Http\Controllers;

use App\Contract;
use Illuminate\Http\Request;
use App\Sale;
use Carbon\Carbon;
use App\Http\Requests\OrderRequest;

class OrderController extends Controller
{
  /**
   * @param Request $request
   */
  public function setOrder(Request $request)
  {

      // Submitted orders
      $orders = $request->all();

      // Order records to be saved
      $order_records = [];

      // Add needed information to book records
      foreach ($orders as $order) {
          if (!empty($order)) {
              // Get the current time
              $now = Carbon::now();

              // Formulate record that will be saved
              $order_records[] = [
                  'type' => $order['credit'],
                  'phone' => $order['phone'],
                  'cost' =>  $order['cost'],
                  'sold_by' => $request->user()->id,
                  'updated_at' => $now,  // remove if not using timestamps
                  'created_at' => $now   // remove if not using timestamps
              ];
              $cost = "";
          }
      }

// Insert Sales records
      Sale::insert($order_records);


      return ['all' => $request->all()];
  }

  private function getAgreement($id)
  {
      $contract= Contract::where('hired', $id)->first();

      return $contract->agreement;
  }
}

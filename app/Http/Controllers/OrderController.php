<?php

namespace App\Http\Controllers;

use App\Contract;
use Illuminate\Http\Request;
use App\Sale;
// use App\User;
use Carbon\Carbon;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\ContractorSales as ContractorSalesResource;

class OrderController extends Controller
{
  /**
   * @param Request $request
   */
  public function setOrder(Request $request)
  {
        // $this->authorize($user); //revizar

      // Submitted orders
      $orders = $request->all();

      // $contractor= $this->getContractor($request);
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
                  'ref' =>  'INV',
                  'sold_by' => $request->user()->id,
                  'hired_by' => 1,
                  'updated_at' => $now,  // remove if not using timestamps
                  'created_at' => $now   // remove if not using timestamps
              ];
              $cost = "";
          }
      }

// Insert Sales records
      Sale::insert($order_records);

      // return response()->json(['message' => $contractor]);

      // return ['all' => $request->all()];
  }

  private function getContractor($request)
  {
      $contract= Contract::where('hired', $request->user()->id)->first();
      $contractor = new ContractorSalesResource($contract);

      return $contractor;
  }
}

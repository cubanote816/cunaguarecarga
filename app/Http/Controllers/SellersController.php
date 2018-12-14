<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contract;
use App\Sale;
use App\User;
use App\Http\Resources\SellersCollection;
use App\Http\Resources\History as HistoryResource;
use App\Http\Resources\HistoryCollection;
use App\Http\Resources\Users as UsersResource;
use App\Http\Resources\RoleCollection;

class SellersController extends Controller
{
  public function getSellers(Request $request)
  {
      $hired_list = Contract::with('hired')
      ->where('contractor', $request->user()->id)
      ->whereHas("hired", function($q){
        $q->where("deleted_at","=",null);
      })
      ->whereHas("hired", function($q){
        $q->where("activation_token","=","");
      })
      ->get();

      // if ($request->get('query')) {
      //     $hired_list->where('name', 'like', '%' . $request->get('query') . '%')
      //         ->orWhere('email', 'like', '%' . $request->get('query') . '%');
      // }
      $result = new SellersCollection($hired_list);
      return ['sellers' => $result];
  }
 private function getSellersInside($id)
  {
    $sellers = Contract::with('hired')
      ->where('contractor', $id)
      ->whereHas("hired", function($q){
        $q->where("deleted_at","=",null);
      })
      ->whereHas("hired", function($q){
        $q->where("activation_token","=","");
      })
      ->get();

// $sellers = new SellerIdCollection($result);
    return $sellers;
  }

private function getRole($id)
    {
      $result = User::find($id);
      
      $role = new UsersResource($result);
      return $result;
  }

  public function getSellerDetail(Request $request)
  {
      // $seller_detail = (new Sale)
      //     ->where('sold_by',$request->id)
      //     ->orderBy('created_at', 'desc')
      //     ->orderBy('type', 'desc')
      //     ->filter($request->only('dateFrom', 'dateTo'));
      // $seller_detail = (new Sale)
      //     ->where('sold_by',$request->id)
      //     ->orderBy('created_at', 'desc')
      //     ->orderBy('type', 'desc')
      //     ->get();

      //     $to_pay = (new Sale)
      //     ->where('sold_by', $request->id)
      //     ->filter($request->only('dateFrom', 'dateTo'))->sum('cost');

      // return ['seller_detail' => $seller_detail->toArray(), 'total_pay' => $to_pay, 'id' => $request->id];


    $ids = array();
    $user = $this->getSellersInside($request->id);
    // $role = $this->getRole($request->id);
    $role= User::find($request->id);
    // foreach ($role as $u_role) {
    //   $user_role = $u_role->role;
    // }
    // $role = 'reseller';
switch ($role->role) {
      
      case 'manager': {
        array_push($ids, $request->id);

        foreach($user as $reseller){
          array_push($ids, $reseller->hired);
          $sellersUser= $this->getSellers($reseller->hired);
          foreach($sellersUser as $sellerUser){
            array_push($ids, $sellerUser->hired);
          }
        } 

        $history = (new Sale)->newQuery();

        foreach($ids as $sold_by){
          $history->orwhere('sold_by', '=', $sold_by);
        }

        $history= $history->get();
        $result= new HistoryCollection($history);
        $result= $result;

        // return ['reports' => $report];
        return ['seller_detail' => $result];
        break;
      }
      case 'reseller': {
        array_push($ids, $request->id);

        foreach($user as $sellerUser){
          array_push($ids, $sellerUser->hired);
        }

        $history = (new Sale)->newQuery();

        foreach($ids as $sold_by){
          $history->orwhere('sold_by', '=', $sold_by);
        }

        $history= $history->get();
        $result= new HistoryCollection($history);
        $result= $result;
        // return ['reports' => $report];
        // return ['role' => $role, 'id' => $request->id];
        return ['seller_detail' => $result];
        break;
      }
      case 'seller': {

        $history = (new Sale)->where('sold_by', '=', $request->id)->get();

        $result= new HistoryCollection($history);
        $result= $result;

        // return ['reports' => $report];
        return ['seller_detail' => $result];
        break;
      }
    }




      // return ['role' => $role->role];


  }

  public function getSellerList(Request $request)
  {
    /** @var User $me */
    $me = auth()->user();
    $ids = array();
    $user = $this->getSellersInside($me->id);
    foreach($user as $sellers){
      array_push($ids, $sellers->hired);
    }
    array_push($ids, $me->id);

    $hired_list = (new User)->newQuery();

    foreach($ids as $id){
      $hired_list->orwhere('id', '=', $id);
    }

    $result= $hired_list->get()->toArray();

    // $hired_list = Contract::with('hired')
    // ->where('contractor', $request->user()->id)
    // ->whereHas("hired", function($q){
    //    $q->where("deleted_at","=",null);
    // })
    // ->WhereHas("hired", function($q){
    //   $q->where("activation_token","=","");
    // })
    // ->latest();

    return ['sellers' => $result];
  }

  public function getSellerNumber(Request $request)
  {
    /** @var User $me */
    $me = auth()->user();
    $ids = array();
    $user = $this->getSellersInside($me->id);
    foreach($user as $sellers){
      array_push($ids, $sellers->hired);
    }

    $hired_list = (new User)->newQuery();

    foreach($ids as $id){
      $hired_list->orwhere('id', '=', $id);
    }

    $result= $hired_list->count();

    // $hired_list = Contract::with('hired')
    // ->where('contractor', $request->user()->id)
    // ->whereHas("hired", function($q){
    //    $q->where("deleted_at","=",null);
    // })
    // ->WhereHas("hired", function($q){
    //   $q->where("activation_token","=","");
    // })
    // ->latest();

    return ['sellers' => count($ids)];
  }
}

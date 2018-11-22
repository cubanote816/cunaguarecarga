<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Sale;
use App\Contract;
use Carbon\Carbon;
use App\Http\Resources\Reports as ReportsResource;
use App\Http\Resources\ReportsCollection;
use App\Http\Resources\History as HistoryResource;
use App\Http\Resources\HistoryCollection;
use App\Http\Resources\Role as RoleResource;
use App\Http\Resources\RoleCollection;

class ReportController extends Controller
{
  private function getSellers($id)
  {
    $sellers = Contract::with('hired')
      ->where('contractor', $id)
      ->get();

// $sellers = new SellerIdCollection($result);
    return $sellers;
  }

  private function getRole($id)
    {
      $result = User::find($id);
      
      $role = new RoleResource($result);
      return $role;
  }

  public function reports(Request $request){
      // if ($request->seller == null)
      // {
      //   // improve that code
      //   //TODO
      //   $reports = (new Sale)
      //     ->where('sold_by', $request->user()->id)
      //     ->orderBy('created_at', 'desc')
      //     ->orderBy('type', 'desc')
      //     ->filter($request->only('dateFrom', 'dateTo'));

      //   $to_pay = (new Sale)
      //     ->where('sold_by', $request->user()->id)
      //     ->filter($request->only('dateFrom', 'dateTo'))->sum('cost');

      // }else{
      //   $reports = (new Sale)
      //     ->orderBy('created_at', 'desc')
      //     ->orderBy('type', 'desc')
      //     ->filter($request->only('seller', 'dateFrom', 'dateTo'));

      //   $to_pay = (new Sale)
      //     ->filter($request->only('seller', 'dateFrom', 'dateTo'))->sum('cost');
      // }
    /** @var User $me */
    $me = auth()->user();
    $ids = array();
    $user = $this->getSellers($me->id);
    switch ($me->role) {
      case 'admin': {
        
        $reports = (new Sale)->newQuery()
          ->orderBy('created_at', 'desc')
          ->orderBy('type', 'desc')
          ->filter($request->only('seller', 'dateFrom', 'dateTo'));

        $result= new ReportsCollection($reports->get());
        $to_pay = $reports->sum('cost');

        return ['reports' => $result, 'total_pay' => $to_pay];
        break;
      }
      case 'manager': {
        array_push($ids, $me->id);
        
        foreach($user as $reseller){
          array_push($ids, $reseller->hired);
          $sellersUser= $this->getSellers($reseller->hired);
          foreach($sellersUser as $sellerUser){
            array_push($ids, $sellerUser->hired);
          }
        }  
        $reports = (new Sale)->newQuery();
        foreach($ids as $sold_by){
          $reports->orwhere(function ($query) use($sold_by) {
            $query->where('sold_by', '=', $sold_by);
          });
        }
          $reports->orderBy('created_at', 'desc')
          ->orderBy('type', 'desc')
          ->filter($request->only('seller','dateFrom', 'dateTo'));

        $result= new ReportsCollection($reports->get());
        $to_pay = $reports->sum('cost');

        return ['reports' => $result, 'total_pay' => $to_pay];
        break;
      }
      case 'reseller': {
        array_push($ids, $me->id);
        foreach($user as $sellerUser){
          array_push($ids, $sellerUser->hired);
        }     

        $reports = (new Sale)->newQuery();
        foreach($ids as $sold_by){
                  $reports->orwhere(function ($query) use($sold_by) {
                    $query->where('sold_by', '=', $sold_by);
                  });
                }
          $reports->orderBy('created_at', 'desc')
          ->orderBy('type', 'desc')
          ->filter($request->only('seller', 'dateFrom', 'dateTo'));

        $result= new ReportsCollection($reports->get());
        $to_pay = $reports->sum('cost');

        return ['reports' => $result, 'total_pay' => $to_pay];
        break;
      }
      case 'seller': {
        array_push($ids, $me->id);
        foreach($user as $sellerUser){
          array_push($ids, $sellerUser->hired);
        }     

        $reports = (new Sale)->newQuery();
        foreach($ids as $sold_by){
          $reports->orwhere(function ($query) use($sold_by) {
            $query->where('sold_by', '=', $sold_by);
          });
        }
          $reports->orderBy('created_at', 'desc')
          ->orderBy('type', 'desc')
          ->filter($request->only('dateFrom', 'dateTo'));

        $result= new ReportsCollection($reports->get());
        $to_pay = $reports->sum('cost');

        return ['reports' => $result, 'total_pay' => $to_pay];
      }
    }
  }

  public function history (Request $request) {
    /** @var User $me */
    $me = auth()->user();
    $ids = array();
    $user = $this->getSellers($me->id);
    switch ($me->role) {
      case 'admin': {
        array_push($ids, $me->id);

        foreach($user as $manager){
          array_push($ids, $manager->hired);
          $resellersUser= $this->getSellers($manager->hired);

          foreach($resellersUser as $reseller){
            array_push($ids, $reseller->hired);
            $sellersUser= $this->getSellers($reseller->hired);

            foreach($sellersUser as $sellerUser){
              array_push($ids, $sellerUser->hired);
            }

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
        return ['history' => $result];
        break;
      }
      case 'manager': {
        array_push($ids, $me->id);

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
        return ['history' => $result];
        break;
      }
      case 'reseller': {
        array_push($ids, $me->id);

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
        return ['history' => $result];
        break;
      }
      case 'seller': {

        $history = (new Sale)->where('sold_by', '=', $me->id)->get();

        $result= new HistoryCollection($history);
        $result= $result;

        // return ['reports' => $report];
        return ['history' => $result];
      }
    }
  }
  public function sales(Request $request)
    {
        /** @var User $me */
        $me = auth()->user();
        $ids = array();
        
        $totalComplete = Sale::where(function ($query) use($me) {
                $query->where('sold_by',  $me['id']);
            })
            ->where(function ($query) {
                $query->where('status', '=', 'complete');
            }) 
            ->count();


        $totalPending = Sale::where(function ($query) use($me) {
            $query->where('sold_by',  $me['id']);
          })
          ->where(function ($query) {
              $query->where('status', '=', 'pending');
          }) 
          ->count();


        $totalDeny = Sale::where(function ($query) use($me) {
                $query->where('sold_by',  $me['id']);
            })
            ->where(function ($query) {
                $query->where('status', '=', 'deny');
            }) 
            ->count();

        array_push($ids, $totalComplete);
        array_push($ids, $totalPending);
        array_push($ids, $totalDeny);

        return ['status' => $ids];
     }

  public function last20 (Request $request) {
    /** @var User $me */
    $me = auth()->user();
    $ids = array();
    $user = $this->getSellers($me->id);
    
        $last20_sale = (new Sale)
        ->where('sold_by', '=', $me->id)
        ->orderBy('created_at', 'desc')
        ->limit(20)
        ->get();

        $result= new HistoryCollection($last20_sale);

        return ['last20' => $result];
     
  }
public function salesStatus (Request $request) {
    /** @var User $me */
    $me = auth()->user();
    $ids = array();
    $sales= Sale::where('sold_by', $me->id)->first();
    if ($sales){
        $totalComplete = Sale::where(function ($query) use($me) {
                $query->where('sold_by',  $me['id']);
            })
            ->where(function ($query) {
                $query->where('status', '=', 'complete');
            }) 
            ->count();


        $totalPending = Sale::where(function ($query) use($me) {
            $query->where('sold_by',  $me['id']);
          })
          ->where(function ($query) {
              $query->where('status', '=', 'pending');
          }) 
          ->count();


        $totalDeny = Sale::where(function ($query) use($me) {
                $query->where('sold_by',  $me['id']);
            })
            ->where(function ($query) {
                $query->where('status', '=', 'deny');
            }) 
            ->count();

        array_push($ids, $totalComplete);
        array_push($ids, $totalPending);
        array_push($ids, $totalDeny);
        return ['status' => $ids];

      }else{

        return ['status' => null];

      }
     
  }

   // public function pay(Request $request)
   //  {
   //      /** @var User $me */
   //      $me = auth()->user();
   //      $sellers= $this->getSellers($me->id);
   //      $ids = array();
   //      // $user = $this->getSellers($me->id);

   //      switch ($me->role) {
   //          case 'admin': {

   //      foreach($sellers as $manager){
   //        array_push($ids, $manager->hired);
   //        $resellersUser= $this->getSellers($manager->hired);

   //        foreach($resellersUser as $reseller){
   //          array_push($ids, $reseller->hired);
   //          $sellersUser= $this->getSellers($reseller->hired);

   //          foreach($sellersUser as $sellerUser){
   //            array_push($ids, $sellerUser->hired);
   //          }

   //        }

   //      }
        
   //              $sellers= $this->getSellers($me->id);
   //              $seles_reseller = (new Sale)->newQuery();
   //              $temp= 0;
   //              $temp2= 0;

   //                      $test = (new Sale)->newQuery();
   //                      foreach($ids as $sold_by){
   //                        $test->where(function ($query) {
   //                            $query->where('status', '=', 'complete');
   //                          })
   //                          ->where(function ($query) use($sold_by) {
   //                            $query->where('sold_by', '=', $sold_by);
   //                          })
   //                          ->whereDate('created_at', '>', Carbon::now()->subDays(30));
   //                           // $seles_reseller_seller->where('sold_by', $conditionSeller->hired)
   //                          // ->whereDate('created_at', '>', Carbon::now()->subDays(30));
   //                        // $temp = $test->sum('cost');
   //                        // $ok = $temp;
   //                      $temp += $test->sum('cost');
   //                      $temp2 += $test->count();

   //                      }

                       
   //              // $subtotal_temp
   //              // $seller_subtotal_temp= $seles->sum('cost'); //obtengo resulatod de reseller
   //              $reseller = $seles_reseller->sum('cost'); //obtengo resulatod de reseller
   //              $count = $seles_reseller->count(); //obtengo resulatod de reseller

   //              $result= $temp;
   //              // $result= $temp + $reseller;
   //              $countTotal= (new User)->where('id', '=', $manager->hired)->get();
   //              // $countTotal= $temp2 + $count;

               
   //              // return $last30Days = $result;
   //              return ['pay' => $result, 'last30DaysSum' => $countTotal];

   //              break;
   //          }
   //          case 'reseller': {
   //              $sellers= $this->getSellers($me->id);
                       
   //              $last30Days = (new Sale)->newQuery();

   //              foreach($sellers as $condition){
   //                $last30Days->where('sold_by', $condition->hired)
   //                  ->where(function ($query) {
   //                    $query->where('status', '=', 'complete');
   //                  }) 
   //                  ->orwhere('sold_by', $me->id)
   //                  ->whereDate('created_at', '>', Carbon::now()->subDays(30));
   //              }


   //              return $last30Days->sum('cost');
   //              break;
   //          }
   //          case 'seller': {
   //              $last30Days = (new Sale)
   //                ->where('sold_by', $me->id)
   //                ->where(function ($query) {
   //                  $query->where('status', '=', 'complete');
   //                }) 
   //                ->whereDate('created_at', '>', Carbon::now()->subDays(30))
   //                ->sum('cost');

   //              return $last30Days;
   //              break;
   //          }
   //      }

  // }
}

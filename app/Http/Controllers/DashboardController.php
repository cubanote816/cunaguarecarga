<?php

namespace App\Http\Controllers;

use App\Entry;
use App\User;
use App\Sale;
use App\Contract;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Http\Resources\SellerIdCollection;
use App\Http\Resources\Role as RoleResource;

/**
 * Class DashboardController
 *
 * @package App\Http\Controllers
 * @resource Dashboards
 */
class DashboardController extends Controller
{
    /**
     * Dashboard
     *
     * Get user dashboard data
     *
     * @param Request $request
     * @return mixed
     */
    public function data(Request $request)
    {
        /** @var User $me */
        $me = auth()->user();

        $week_chart = DB::table('entries')
            ->select(DB::raw('avg(speed) as avg_speed, avg(distance) as avg_distance, date'))
            ->where('user_id', $me->id)
            ->where('date', '>=', Carbon::now()->subWeeks(2)->toDateString())
            ->groupBy('date')
            ->get()->map(function ($item) {
                return [Carbon::parse($item->date)->format('m/d'), round($item->avg_speed, 2), round($item->avg_distance, 2)];
            });

        return [
            'weekly_count' => $me->entries()->where('date', '>=', Carbon::now()->startOfWeek()->toDateString())->count(),
            'weekly_avg_speed' => $me->entries()->where('date', '>=', Carbon::now()->startOfWeek()->toDateString())->avg('speed'),
            'weekly_avg_pace' => $me->entries()->where('date', '>=', Carbon::now()->startOfWeek()->toDateString())->avg('pace'),
            'week_chart' => $week_chart,
            'max_speed' => $me->entries()->max('speed'),
            'max_distance' => $me->entries()->max('distance'),
            'max_time' => $me->entries()->max('time'),
        ];
    }

    /**
     * Admin dashboard
     *
     * Get admin dashboard data
     *
     * @param Request $request
     * @return mixed
     */
    public function adminData(Request $request)
    {
        /** @var User $me */
        $me = auth()->user();

        if ( ! $me->isAdmin() && ! $me->isManager()) abort(401);

        $usersCount = User::count();
        $entriesCount = Entry::count();

        return [
            'total_users' => $usersCount,
            'new_users_this_week' => User::where('created_at', '>=', Carbon::now()->startOfWeek()->toDateTimeString())->count(),
            'new_users_this_month' => User::where('created_at', '>=', Carbon::now()->startOfMonth()->toDateTimeString())->count(),
            'total_entries' => $entriesCount,
            'avg_entries_per_user' => round($entriesCount / $usersCount),
            'fastest_run' => Entry::with('user')->whereRaw('speed = (select max(`speed`) from entries)')->first(),
            'longest_run' => Entry::with('user')->whereRaw('distance = (select max(`distance`) from entries)')->first(),
        ];
    }

    private function getSellers($id)
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
        
        $role = new RoleResource($result);
        return $role;
    }

    public function salesLast30Days(Request $request)
    {
        /** @var User $me */
        $me = auth()->user();
        $sellers= $this->getSellers($me->id);

        switch ($me->role) {
            case 'admin': {
                $last30Days = (new Sale)
                ->where(function ($query) {
                  $query->where('status', '=', 'complete');
                })               
                ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->sum('cost');

                $last30DaysCount = (new Sale)
                ->where(function ($query) {
                  $query->where('status', '=', 'complete');
                })  
                ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->count();
                return ['last30Days' => $last30Days, 'last30DaysSum' => $last30DaysCount];
                break;
            }
            case 'manager': {
                $sellers= $this->getSellers($me->id);
                $seles_reseller = (new Sale)->newQuery();
                $temp= 0;
                $temp2= 0;
                foreach($sellers as $condition){
                    $seles_reseller->where('sold_by', $me->id)
                            ->where(function ($query) {
                              $query->where('status', '=', 'complete');
                            }) 
                            ->whereDate('created_at', '>', Carbon::now()->subDays(30));
                    $role = $this->getRole($condition->hired);

                    // $tt = 'reseller';
                    // $tt = $role->role;
                    if($role->role == 'reseller'){
                        $resellers= $this->getSellers($condition->hired);
                        $test = (new Sale)->newQuery();
                        foreach($resellers as $conditionSeller){
                          $test->where(function ($query) {
                              $query->where('status', '=', 'complete');
                            })
                            ->where(function ($query) use($conditionSeller) {
                              $query->where('sold_by', '=', $conditionSeller['hired'])
                              ->orwhere('sold_by', $conditionSeller['contractor']);
                            })
                            ->whereDate('created_at', '>', Carbon::now()->subDays(30));
                             // $seles_reseller_seller->where('sold_by', $conditionSeller->hired)
                            // ->whereDate('created_at', '>', Carbon::now()->subDays(30));
                          // $temp = $test->sum('cost');
                          // $ok = $temp;
                        $temp += $test->sum('cost');
                        $temp2 += $test->count();

                        }

                        // $temp= $temp + $seles_reseller_seller->sum('cost');
                        // $temp= $temp + $seles_reseller_seller->sum('cost');
                    }
                
                } // end foreach
                // $subtotal_temp = $temp + $seles_reseller_seller->sum('cost'); // obtengo los vendedores
                
                // $subtotal_temp
                // $seller_subtotal_temp= $seles->sum('cost'); //obtengo resulatod de reseller
                $reseller = $seles_reseller->sum('cost'); //obtengo resulatod de reseller
                $count = $seles_reseller->count(); //obtengo resulatod de reseller

                $result= $temp + $reseller;
                $countTotal= $temp2 + $count;

               
                // return $last30Days = $result;
                return ['last30Days' => $result, 'last30DaysSum' => $countTotal];

                break;
            }
            case 'reseller': {
              $sellers= $this->getSellers($me->id);
              $seles_reseller = (new Sale)->newQuery();
              $temp= 0;
              $temp2= 0;
              $ids= array();
              foreach($sellers as $sellerUser){
                array_push($ids, $sellerUser->hired);
              }
              
              array_push($ids, $me->id);

              foreach($ids as $sold_by){
                          $seles_reseller->orwhere('sold_by', '=', $sold_by)
                          ->where(function ($query) {
                              $query->where('status', '=', 'complete');
                            })
                            ->whereDate('created_at', '>', Carbon::now()->subDays(30));

                        }
              $totalSale = $seles_reseller->sum('cost');
              $totalNumberSales = $seles_reseller->count();
              // $totalSale = $seles_reseller->get(); //btengo resulatod de reseller

              // $totalSale = $seles_reseller->sum('cost'); //obtengo resulatod de reseller
              // $totalNumberSales = $seles_reseller->count(); //obtengo resulatod de reseller

              return ['last30Days' => $totalSale, 'last30DaysSum' => $totalNumberSales];
              break;
            }
            case 'seller': {
                $seles_seller = (new Sale)
                  ->where('sold_by', $me->id)
                  ->where(function ($query) {
                    $query->where('status', '=', 'complete');
                  }) 
                  ->whereDate('created_at', '>', Carbon::now()->subDays(30));

                $totalSale = $seles_seller->sum('cost');
                $totalNumberSales = $seles_seller->count();
                
                return ['last30Days' => $totalSale, 'last30DaysSum' => $totalNumberSales];
                break;
            }
        }

  }
  
  // public function salesMonthly(Request $request){
  //   /** @var User $me */
  //       $me = auth()->user();
  //       $sellers= $this->getSellers($me->id);

  //       switch ($me->role) {
  //           case 'admin': {
  //               $monthly = (new Sale)
  //               ->where(function ($query) {
  //                 $query->where('status', '=', 'complete');
  //               })               
  //               ->sum('cost')
  //               ->groupBy(function($val){
  //                 return Carbon::parse($val->created_at)->format('M');
  //               });

  //               $last30DaysCount = (new Sale)
  //               ->where(function ($query) {
  //                 $query->where('status', '=', 'complete');
  //               })  
  //               ->whereDate('created_at', '>', Carbon::now()->subDays(30))
  //               ->count();
  //               return ['last30Days' => $last30Days, 'last30DaysSum' => $last30DaysCount];
  //               break;
  //           }
  //           case 'manager': {
  //               $sellers= $this->getSellers($me->id);
  //               $seles_reseller = (new Sale)->newQuery();
  //               $temp= 0;
  //               $temp2= 0;
  //               foreach($sellers as $condition){
  //                   $seles_reseller->where('sold_by', $me->id)
  //                           ->where(function ($query) {
  //                             $query->where('status', '=', 'complete');
  //                           }) 
  //                           ->whereDate('created_at', '>', Carbon::now()->subDays(30));
  //                   $role = $this->getRole($condition->hired);

  //                   // $tt = 'reseller';
  //                   // $tt = $role->role;
  //                   if($role->role == 'reseller'){
  //                       $resellers= $this->getSellers($condition->hired);
  //                       $test = (new Sale)->newQuery();
  //                       foreach($resellers as $conditionSeller){
  //                         $test->where(function ($query) {
  //                             $query->where('status', '=', 'complete');
  //                           })
  //                           ->where(function ($query) use($conditionSeller) {
  //                             $query->where('sold_by', '=', $conditionSeller['hired'])
  //                             ->orwhere('sold_by', $conditionSeller['contractor']);
  //                           })
  //                           ->whereDate('created_at', '>', Carbon::now()->subDays(30));
  //                            // $seles_reseller_seller->where('sold_by', $conditionSeller->hired)
  //                           // ->whereDate('created_at', '>', Carbon::now()->subDays(30));
  //                         // $temp = $test->sum('cost');
  //                         // $ok = $temp;
  //                       $temp += $test->sum('cost');
  //                       $temp2 += $test->count();

  //                       }

  //                       // $temp= $temp + $seles_reseller_seller->sum('cost');
  //                       // $temp= $temp + $seles_reseller_seller->sum('cost');
  //                   }
                
  //               } // end foreach
  //               // $subtotal_temp = $temp + $seles_reseller_seller->sum('cost'); // obtengo los vendedores
                
  //               // $subtotal_temp
  //               // $seller_subtotal_temp= $seles->sum('cost'); //obtengo resulatod de reseller
  //               $reseller = $seles_reseller->sum('cost'); //obtengo resulatod de reseller
  //               $count = $seles_reseller->count(); //obtengo resulatod de reseller

  //               $result= $temp + $reseller;
  //               $countTotal= $temp2 + $count;

               
  //               // return $last30Days = $result;
  //               return ['last30Days' => $result, 'last30DaysSum' => $countTotal];

  //               break;
  //           }
  //           case 'reseller': {
  //               $sellers= $this->getSellers($me->id);
                       
  //               $last30Days = (new Sale)->newQuery();

  //               foreach($sellers as $condition){
  //                 $last30Days->where('sold_by', $condition->hired)
  //                   ->where(function ($query) {
  //                     $query->where('status', '=', 'complete');
  //                   }) 
  //                   ->orwhere('sold_by', $me->id)
  //                   ->whereDate('created_at', '>', Carbon::now()->subDays(30));
  //               }


  //               return $last30Days->sum('cost');
  //               break;
  //           }
  //           case 'seller': {
  //               $last30Days = (new Sale)
  //                 ->where('sold_by', $me->id)
  //                 ->where(function ($query) {
  //                   $query->where('status', '=', 'complete');
  //                 }) 
  //                 ->whereDate('created_at', '>', Carbon::now()->subDays(30))
  //                 ->sum('cost');

  //               return $last30Days;
  //               break;
  //           }
  //       }

  // }
  
  

  // public function sales(Request $request){

  //   /** @var User $me */
  //   $me = auth()->user();
  //   $total_sales= $this->totalSales($me->id);

  //   $totalPending = Sale::where('status', '=', 'pending')
  //       ->where(function ($query) {
  //           $query->where('sold_by',  $me->id);
  //       })
  //       ->count();

  //       $totalPercentPending = ($totalPending * 100) / $total_sales;

  //    // return [];
  //   // }
  //   // total deny
  //   // public function totalDeny(Request $request){
  //    $totalDeny = Sale::where('status', '=', 'deny')
  //    ->where(function ($query) {
  //           $query->where('sold_by',  $me->id);
  //       })
  //    ->count();
  //       $totalPercentDeny = ($totalDeny * 100) / $total_sales;

  //    // return [];
    
  //   // total pending
  //   // public function totalComplete(Request $request){
  //    $totalComplete = Sale::where('status', '=', 'complete')
  //    ->where(function ($query) {
  //           $query->where('sold_by',  $me->id);
  //       })
  //    ->count();
  //       $totalPercentComplete = ($totalComplete * 100) / $total_sales;

  //       // return ['totalPending' => $totalPending, 'totalDeny' => $totalDeny, 'totalComplete' => $totalComplete, 'totalSales'=> $this->totalSales($request)];
  //       // return ['totalPending' => 90, 'totalPercentComplete' => 80, 'totalPending' => 78, 'totalPercentDeny' => 98, 'totalSales'=> $this->totalSales($request), 'totalPending' => 67, 'totalPercentPending' => 90];
  //       return ['totalPending' => $totalPending, 'totalPercentComplete' => $totalPercentComplete, 'totalPending' => $totalPending, 'totalPercentDeny' => $totalPercentDeny, 'totalSales'=> $total_sales, 'totalPending' => $totalPending, 'totalPercentPending' => $totalPercentPending];
  //   }


    private function totalSales($id){
        $totalSales = Sale::where('sold_by', $id)->count();

         return $totalSales;
    }
}

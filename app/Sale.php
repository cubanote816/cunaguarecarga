<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Contract;
use App\Http\Resources\Role as RoleResource;
use App\Http\Resources\RoleCollection;

class Sale extends Model
{
protected $fillable = [
    'type', 'number', 'agreement', 'sold_by'
];


/* ========================================================================= *\
 * Relations
\* ========================================================================= */

/**
 * Belongs to user
 */
public function user()
{
    return $this->belongsTo(User::class, 'sold_by');
}

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

/**
 * Apply filters
 *
 * @param Builder $query
 * @param $filters
 */
public function scopeFilter($query, $filters)
{
    foreach ($filters as $filter => $value) {
        if ( ! $value) continue;
        switch ($filter) {
            case 'dateFrom':
                $query->where('created_at', '>=', Carbon::parse($value)->toDateString());
                break;
            case 'dateTo':
                $query->where('created_at', '<=', Carbon::parse($value)->toDateString());
                break;
          case 'seller':
            if ($value == auth()->user()->id) {
              $query->where('sold_by', '=', $value);
            }else{
              $ids = array();
              $user = $this->getSellers($value);
              $role = $this->getRole($value);
              if ($role->role == 'manager'){
                array_push($ids, $value);

                foreach($user as $reseller){
                  array_push($ids, $reseller->hired);
                  $userRole = $this->getRole($reseller->hired);
                  
                  if ($userRole->role == 'reseller') {
                    $sellersUser= $this->getSellers($reseller->hired);
                    foreach($sellersUser as $sellerUser){
                      array_push($ids, $sellerUser->hired);
                    }
                  }
                } 

                foreach($ids as $sold_by){
                  $query->orwhere(function ($query) use($sold_by) {
                    $query->where('sold_by', '=', $sold_by);
                  });
                }
              }

              if ($role->role == 'reseller'){
                array_push($ids, $value);

                foreach($user as $sellerUser){
                  array_push($ids, $sellerUser->hired);
                }
                foreach($ids as $sold_by){
                  $query->orwhere(function ($query) use($sold_by) {
                    $query->where('sold_by', '=', $sold_by);
                  });
                }

              }
              if ($role->role == 'seller'){
                  $query->where('sold_by', '=', $value);
                
                return $query;
              }
            }
            break;
        }
    }
}
}

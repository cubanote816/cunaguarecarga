<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        }
    }
}

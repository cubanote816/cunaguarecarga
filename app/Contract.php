<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = ['contractor', 'hired', 'status', 'agreement'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function hired()
    {
        return $this->belongsTo(User::class, 'hired', 'id', 'hired');
    }

    public function contractor()
    {
        return $this->belongsTo(User::class, 'contractor', 'id', 'contractor');
    }

}

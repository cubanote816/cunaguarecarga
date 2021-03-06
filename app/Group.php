<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['owner', 'member', 'status'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

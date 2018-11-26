<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    // use SoftDeletes;
    // protected $dates = ['deleted_at'];
    
    protected $fillable = ['contractor', 'hired', 'status', 'agreement'];

	/**
     * User has many Contract
     */
    // public function user()
    // {
    //     return $this->belongsTo('App\User', );
    // }
    public function user()
    {
        return $this->belongsTo('App\User');
    }

	/**
     * Hired has one contract
     */
    public function hired()
    {
        return $this->belongsTo(User::class, 'hired', 'id', 'hired');
    }

    public function employer()
    {
        return $this->belongsTo('App\User');
    }

	/**
     * Contract belongsTo User
     */
    public function contractors()
    {
        return $this->belongsTo(User::class, 'contractor', 'id', 'contractor');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = ['contractor', 'hired', 'status', 'agreement'];

	/**
     * User has many Contract
     */
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

	/**
     * Contract belongsTo User
     */
    public function contractor()
    {
        return $this->belongsTo(User::class, 'contractor', 'id', 'contractor');
    }

}

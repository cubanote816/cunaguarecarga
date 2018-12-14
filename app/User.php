<?php

namespace App;

use App\Traits\Member;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, HasApiTokens, Notifiable, SoftDeletes, Member;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active', 'role', 'activation_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot() {
        parent::boot();

        static::deleting(function($user) {
            $user->contract()->delete();
        });
    }


    /* ========================================================================= *\
     * Relations
    \* ========================================================================= */

    /**
     * Owner has many Member
     */
public function owner()
    {
        return $this->belongsToMany(User::class, 'groups', 'owner', 'member');
    }

	/**
     * Member has one Owner
     */
    public function member()
    {
        return $this->belongsToMany(User::class, 'groups', 'member', 'owner');
    }

	/**
     * Hired has one Contractor
     */
	public function hired()
    {
        return $this->belongsToMany(User::class, 'contracts', 'contractor', 'hired');
    }

	/**
     * contractor has many Hired
     */
    public function contractors()
    {
        return $this->belongsToMany(User::class, 'contracts', 'hired', 'contractor');
    }

	/**
     * Usear has many Contract
     */
    // public function contracts()
    // {
    //     return $this->hasMany(Contract::class);
    // }
    public function contract()
    {
        return $this->hasOne('App\Contract', 'hired');
    }

    /* ========================================================================= *\
     * Helpers
    \* ========================================================================= */

    /**
     * Get existing or make new access token
     */
    public function makeApiToken()
    {
        return $this->createToken('API')->accessToken;
    }

    /**
     * Is user admin
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Is user manager
     *
     * @return bool
     */
    public function isManager()
    {
        return $this->role === 'manager';
    }

    /**
     * Is user reseller
     *
     * @return bool
     */
    public function isReseller()
    {
        return $this->role === 'reseller';
    }

    /**
     * Is user seller
     *
     * @return bool
     */
    public function isSeller()
    {
        return $this->role === 'seller';
    }
}

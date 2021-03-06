<?php

namespace App;

use App\Notifications\EmailProductOrderedCustomer;
use App\Notifications\EmailProductOrderedMerchant;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\EmailRegistration;

class User extends Authenticatable implements JWTSubject{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'role', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    public function profile() {
        return $this->hasOne('App\Profile');
    }

    public function emailVerification() {
        return $this->hasOne('App\VerifyUser');
    }

    public function products() {
        return $this->hasMany('App\Product');
    }

    public function cart() {
        return $this->hasOne('App\Cart');
    }

    public function orders() {
        return $this->hasMany('App\Order', 'customer_id');
    }

    public function sendEmailVerificationNotification() {
        $this->notify(new EmailRegistration($this));
    }

    public function sendOrderedProductEmailToCustomer() {
        $this->notify(new EmailProductOrderedCustomer($this));
    }

    public function sendOrderedProductEmailToMerchant() {
        $this->notify(new EmailProductOrderedMerchant($this));
    }
}

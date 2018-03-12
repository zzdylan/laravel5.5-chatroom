<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject {

    use Notifiable;

    protected $guard_name = 'api';
    protected $table = 'users';
    protected $fillable = [ 'username', 'password', 'avatar'];
    protected $hidden = ['password'];

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    // public function getAvatarAttribute($value) {
    //     return $value ? asset($value) : asset('images/default_avatar.jpg');
    // }

}

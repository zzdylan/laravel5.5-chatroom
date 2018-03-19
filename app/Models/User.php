<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable implements JWTSubject {

    use Notifiable;
    use LogsActivity;

    protected $guard_name = 'api';
    protected $table = 'users';
    protected $fillable = [ 'username', 'password', 'avatar'];
    protected $hidden = ['password'];
    protected static $logAttributes = ['username'];
    protected static $logOnlyDirty = true;

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    public function getDescriptionForEvent(string $eventName): string
    {
    	switch ($eventName) {
    		case 'created':
    			return '注册了聊天室';
    		case 'updated':
    			return '更新了资料';
    		default:
    			return $eventName;
    	}
    }

    public function friendCircles(){
        return $this->hasMany(FriendCircle::class,'user_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class,'user_id');
    }

}

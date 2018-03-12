<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatRecord extends Model
{
    protected $table = 'chat_records';
    protected $guarded = [];

    public function getTypeAttribute($value){
    	$type = [1=>'text',2=>'image'];
    	return $type[$value];
    }
}

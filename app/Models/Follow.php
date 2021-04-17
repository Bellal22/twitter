<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;
    protected $guarded = [];

    // users that are followed by this user
public function following() {
    return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id');
}

// users that follow this user
public function followers() {
    return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id');
}
public static function validate_exist($request){
    return Follow::where('follower_id',$request['follower_id'])->where('following_id',$request['following_id'])->exists();
}

}

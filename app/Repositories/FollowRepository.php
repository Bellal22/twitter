<?php 
namespace App\Repositories; 

use App\Models\Follow;


class FollowRepository {
    
    public function store_follow($request){
        $request['follower_id'] = auth()->user()->id;
        $exist = Follow::validate_exist($request);
        
        $tweet = !$exist ? Follow::create($request) : false ; 
        return $tweet; 
    }
    // 
}
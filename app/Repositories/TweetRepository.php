<?php 
namespace App\Repositories; 

use App\Models\Tweet;

class TweetRepository {
    public function all(){
       return Tweet::with('user')->get()->map->format();
    }
    public function find_by_id($tweet_id){
        return Tweet::where('id',$tweet_id)->with('user')->firstOrFail()->format();
     }
    // 
}
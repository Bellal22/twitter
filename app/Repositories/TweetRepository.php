<?php 
namespace App\Repositories; 

use App\Models\Tweet;


class TweetRepository implements PublishRepositoryInterface{
    public function all(){
       return Tweet::with('user')->get()->map->format();
    }
    public function find_by_id($tweet_id){
        return Tweet::where('id',$tweet_id)->with('user')->firstOrFail()->format();
    }
    public function store_tweet($request){
        $tweet =  Tweet::create($request);
        return $tweet; 
    }
    // 
}
<?php 
namespace App\Repositories; 

use App\Models\Tweet;
use PDF;



class TweetRepository implements PublishRepositoryInterface{
    public function all(){
        $tweets= Tweet::with('user')->get()->map->format();
      return $tweets; 
    }
    public function find_by_id($tweet_id){
        return Tweet::where('id',$tweet_id)->with('user')->firstOrFail()->format();
    }
    public function store_tweet($request){
        $tweet = Tweet::create($request);
        return $tweet; 
    }
    // 
}
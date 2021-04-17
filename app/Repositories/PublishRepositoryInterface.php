<?php 
namespace App\Repositories; 

interface PublishRepositoryInterface{
    public function all();
    public function find_by_id($tweet_id);
}
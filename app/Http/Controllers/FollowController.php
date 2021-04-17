<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;
use App\Http\Requests\CreateFollowRequest;
use App\Repositories\FollowRepository; 

class FollowController extends Controller
{

    private $followRepository; 

    public function __construct(FollowRepository $followRepository){
        $this->followRepository = $followRepository;
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateFollowRequest $request)
    {
        $follow = $this->followRepository->store_follow($request->validated()); 
        return $follow ?  response()->json($follow,201) :  response()->json(['message' => 'Already exists'],401);
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Follow  $follow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Follow $follow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Follow  $follow
     * @return \Illuminate\Http\Response
     */
    public function destroy(Follow $follow)
    {
        //
    }
}

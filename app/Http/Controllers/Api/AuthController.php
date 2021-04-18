<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
// use Intervention\Image\Facades\Image;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\LoginRequest;
// use Illuminate\Support\Facades\RateLimiter;
use App\Repositories\AuthRepository; 




class AuthController extends Controller
{
    private $authRepository; 

    public function __construct(AuthRepository $authRepository){
        $this->authRepository = $authRepository;
    }


    public function register(UserStoreRequest $request) {
        
        $data = $this->authRepository->register_user($request->validated());
      
        return response([ 'user' => $data[0], 'access_token' => $data[1]]);
    }
      
    public function login(LoginRequest $request) {

        $accessToken = $this->authRepository->login_user($request->validated());
        
        switch ($accessToken) {
            case 401:
                return response()->json([
                    'status_code' => 401,
                    'message' => 'Unauthorized',
                ]);
                break;
            
            case 500:
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Error occured while loggin in.',
                    
                ]);
                break;
        }
        
        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }
        
      
      
      
      public function user(Request $request) { 
        return response()->json($request->user());
      }
      
}

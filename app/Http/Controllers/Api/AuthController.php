<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Intervention\Image\Facades\Image;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Support\Facades\RateLimiter;




class AuthController extends Controller
{
    public function register(UserStoreRequest $request) {
        
        $validatedData = $request->validated();
        // dd($validatedData);
    
        $imagePath = request('image')->store('uploads', 'public');
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        $image->save();

        $validatedData['password'] = bcrypt($request->password);
        // dd($validatedData);
        $validatedData['image'] = $imagePath;
        $user = User::create($validatedData);
        $accessToken = $user->createToken('authToken')->accessToken;
      
        return response([ 'user' => $user, 'access_token' => $accessToken]);
    }
      
    public function login(Request $request) {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
        $this->checkTooManyFailedAttempts();

        $user = User::where('email', $request->email)->first();

        try { 
            if (!auth()->attempt($loginData)) {
                RateLimiter::hit($this->throttleKey(), $seconds = 180);
                return response()->json([
                    'status_code' => 401,
                    'message' => 'Unauthorized',
                ]);
            }
            if (!\Hash::check($request->password, $user->password, [])) {
                throw new Exception('Error occured while logging in......');
            }
                
            $accessToken = auth()->user()->createToken('authToken')->accessToken;
            RateLimiter::clear($this->throttleKey());
            return response(['user' => auth()->user(), 'access_token' => $accessToken]);


        } catch (\Throwable $th) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error occured while loggin in.',
                'error' => $th,
            ]);

        }
        
        // if (!auth()->attempt($loginData)) {
        //   return response(['message' => 'Invalid Credentials']);
        // }
        
        // $accessToken = auth()->user()->createToken('authToken')->accessToken;
        // return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }
        /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return \Str::lower(request('email')) . '|' . request()->ip();
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
    */
      public function checkTooManyFailedAttempts()
        {
            
            if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
                return;
            }

            throw new \Exception('IP address banned. Too many login attempts, please waite for 3 minutes and Try again!');
        }

      
      public function logout(Request $request) {
        if (Auth::check()) {
            Auth::user()->AauthAcessToken()->delete();
         }
        // $request->user()->token()->revoke();
        return response()->json([
          'message' => 'Successfully logged out'
        ]);
      }
      
      public function user(Request $request) { 
        return response()->json($request->user());
      }
      
}

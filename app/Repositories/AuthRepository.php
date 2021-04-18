<?php 
namespace App\Repositories; 

use App\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



class AuthRepository {
    
    public function register_user($request){
        $imagePath = $this->store_image(request('image')->store('uploads', 'public'));
        // $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        // $image->save();

        $request['password'] = bcrypt($request['password']);
        // dd($request);
        $request['image'] = $imagePath;
        $user = User::create($request);
        $accessToken = $user->createToken('authToken')->accessToken;
        return [$user,$accessToken]; 
    }

    public function store_image($imagePath){
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        $image->save();
        return $imagePath ; 
    }

    public function login_user($request){
        $this->checkTooManyFailedAttempts();

        $user = User::where('email', $request['email'])->first();

        try { 
            if (!auth()->attempt($request)) {
                RateLimiter::hit($this->throttleKey(), $seconds = 180);
                return 401 ; 
            }
            if (!\Hash::check($request['password'], $user->password, [])) {
                throw new Exception('Error occured while logging in......');
            }
                
            $accessToken = auth()->user()->createToken('authToken')->accessToken;
            RateLimiter::clear($this->throttleKey());
            return $accessToken;


        } catch (\Throwable $th) {
            return 500;

        }
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

}
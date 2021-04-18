<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    private $userRepository; 

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }


    public function index()
    {
        $users = $this->userRepository->report();
        return $users;
    }

}

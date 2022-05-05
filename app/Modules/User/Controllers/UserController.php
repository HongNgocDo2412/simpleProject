<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegister;
use App\Modules\User\Requests\UserLoginRequest;
use App\Modules\User\Requests\UserRegisterRequest;
use App\Modules\User\Services\Interfaces\UserServiceInterface;
use App\Modules\User\Services\UserService;
use Illuminate\Http\Response;

class UserController extends Controller
{
    private $userService;

    /**
    * Construct any application services.
    *
    * @return void
    */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }
    /**
    * Register App.
    *
    * @return void
    */
    public function register(UserRegisterRequest $request)
    {
        return $this->userService->register($request);
    }
    /**
    * Login App.
    *
    * @return void
    */
    public function login(UserLoginRequest $request)
    {
        return $this->userService->login($request);
    }
    /**
    *L getCurrentUser.
    *
    * @return void
    */
    public function getCurrentUser()
    {
        return $this->userService->getUser();
    }
}

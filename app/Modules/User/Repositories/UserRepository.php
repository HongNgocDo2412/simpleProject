<?php

namespace App\Modules\User\Repositories;

use App\Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use App\Modules\User\Models\User;

class UserRepository implements UserRepositoryInterface
{
     /**
     * register
     * 
     * @param $request
     * @return Response 
     */
    public function register(array $data)
    {
      return User::create($data);
    }
  /**
     * login
     * 
     * @param $request
     * @return Response 
     */
    public function login($email) 
    {
        return User::where('email', $email)->first();
    }
}
<?php

namespace App\Modules\User\Services\Interfaces;

interface UserServiceInterface
{
    public function register($request);
    public function login($request);
    public function getUser();
}
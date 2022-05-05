<?php
namespace App\Modules\User\Repositories\Interfaces;

interface UserRepositoryInterface 
{
    public function register(array $data);
    public function login($email);
}
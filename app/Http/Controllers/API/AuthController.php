<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRegister;
use App\Http\Requests\UserLogin;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class AuthController extends Controller
{
    public function register(UserRegister $request)
    {
        try {
            $validated = $request->validated();
            $validated['password'] = bcrypt($validated['password']);
            $user = User::create($validated);
            $token = $user->createToken('simple_project')->accessToken;
    
            return response()->json([ 'user' => $user, 'token' => $token,'message'=>' register successfully'],200);
        } catch (QueryException $ex) {
            return response()->json(['errors' => $ex->getMessage()],500);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['errors' => $ex->getMessage()],404);
        }
       

    }
    public function login(UserLogin $request)
    {
        try {
            $validated = $request->validated();
            if (!Auth::attempt($validated))
            {
                return response(['error_message' => 'Incorrect Details. Please try again']);
            } else {
                $user = auth()->user();
                $token = $user->createToken('simple_project')->accessToken;
                return response()->json(['user' => $user, 'token' => $token, 'message' => 'Logged in successfully'], 200);
            }
        } catch (ModelNotFoundException $ex) {
            return response()->json(['errors' => $ex->getMessage()],404);
        }
    }

    public function getUser()
    {
        try {
            $user = auth()->user();
            return response()->json(['user' => $user], 200);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['errors' => $ex->getMessage()],404);
        }
    }
}

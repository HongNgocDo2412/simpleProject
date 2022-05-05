<?php
namespace App\Modules\User\Services;

use App\Modules\User\Controllers;
use App\Modules\User\Requests\UserLoginRequest;
use App\Modules\User\Requests\RegisterLoginRequest;
use App\Modules\User\Services\Interfaces\UserServiceInterface;
use App\Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Helpers\TransformerResponse;
use App\Modules\User\Repositories\UserRepository;

class UserService implements UserServiceInterface
{
    private $transformerResponse;
    private $userRepository;
    const INVALID_CREDENTIAL = 'INVALID_CREDENTIAL';
    const LOGIN_SUCCESS = 'LOGIN_SUCCESS';
    const REGISTER_SUCCESS = 'REGISTER_SUCCESS';

    public function __construct(
        TransformerResponse $transformerResponse,
        UserRepositoryInterface $userRepository  
    )
    {
        $this->transformerResponse = $transformerResponse;
        $this->userRepository = $userRepository;
    }
    /**
     * register
     * 
     * @param $request
     * @return Response 
     */
    public function register($request)
    {
        $validated = $request->validated();
        $validated['password'] = bcrypt($validated['password']);
        try {
            $user = $this->userRepository->register($validated);
            $token = $user->createToken('simple_project')->accessToken;
            return $this->transformerResponse->response(
                false,
                [
                    'user' => $user,
                    'token' => $token
                ],
                TransformerResponse::HTTP_CREATED,
                self::REGISTER_SUCCESS
        );  
        } catch (QueryException $ex) {
            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_INTERNAL_SERVER_ERROR,
                TransformerResponse::INTERNAL_SERVER_ERROR_MESSAGE,
            );
        } catch (ModelNotFoundException $ex) {
            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_NOT_FOUND,
                TransformerResponse::NOT_FOUND_MESSAGE,
            );
        }
    }
     /**
     * login
     * 
     * @param $request
     * @return Response 
     */
    public function login($request)
    {
        try {
            $validated = $request->validated();
            if (!Auth::attempt($validated)) {
                    return $this->transformerResponse->response(
                    true,
                    [],
                    TransformerResponse::HTTP_BAD_REQUEST,
                    self::INVALID_CREDENTIAL      
                ); 
            } 
            $accessToken = $this->userRepository->login($validated['email'])->createToken('simple_project')->accessToken;
            return $this->transformerResponse->response(
                false,
                [
                    'user' => Auth::user(),
                    'accessToken' => $accessToken
                ],
                TransformerResponse::HTTP_OK,
                self::LOGIN_SUCCESS  
            );  
        } catch (QueryException $ex) {
            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_INTERNAL_SERVER_ERROR,
                TransformerResponse::INTERNAL_SERVER_ERROR_MESSAGE,
            );
        } catch (ModelNotFoundException $ex) {
            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_NOT_FOUND,
                TransformerResponse::NOT_FOUND_MESSAGE,
            );
        } 
    }
     /**
     * getUser
     * 
     * @param $request
     * @return Response 
     */
    public function getUser()
    {
        try {
            return $this->transformerResponse->response(
                false,
                [
                    'user' => Auth::user(),
                ],
                TransformerResponse::HTTP_OK,
                TransformerResponse::GET_SUCCESS_MESSAGE 
            );  
        } catch (QueryException $ex) {
            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_INTERNAL_SERVER_ERROR,
                TransformerResponse::INTERNAL_SERVER_ERROR_MESSAGE,
            );
        } catch (ModelNotFoundException $ex) {
            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_NOT_FOUND,
                TransformerResponse::NOT_FOUND_MESSAGE,
            );
        } 
    }
}
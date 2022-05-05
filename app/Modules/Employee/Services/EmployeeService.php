<?php
namespace App\Modules\employee\Services;

use App\Modules\Employee\Controllers;
use App\Modules\Employee\Repositories\EmployeeRepository;
use App\Modules\Employee\Requests\Create;
use App\Modules\Employee\Requests\Update;
use App\Modules\Employee\Services\Interfaces\EmployeeServiceInterface;
use App\Modules\Employee\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Helpers\TransformerResponse;
use Illuminate\Http\Response;

class EmployeeService implements EmployeeServiceInterface
{
    private $transformerResponse;
    private $employeeRepository;
    const ID_NOT_EXISTS = 'ID_NOT_EXISTS';
    const DELETE_FAILED = 'DELETE_FAILED';

    public function __construct(
        TransformerResponse $transformerResponse,
        EmployeeRepositoryInterface $employeeRepository 
    )
    {
        $this->transformerResponse = $transformerResponse;
        $this->employeeRepository = $employeeRepository;
    }
    /**
     * get all employee
     * 
     * @param $request
     * @return Response 
     */
    public function getAll()
    {    
        try {
            $employee = $this->employeeRepository->getAll();
            return $this->transformerResponse->response(
                false,
                [
                    'employee' => $employee
                ],
                TransformerResponse::HTTP_OK,
                TransformerResponse::GET_SUCCESS_MESSAGE,
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
     * create employee
     * 
     * @param $request
     * @return Response 
     */
    public function create($request)
    {
        try {
            $validated = $request->validated();
            $employee = $this->employeeRepository->create($validated);
            return $this->transformerResponse->response(
                false,
                [
                    'employee' => $employee
                ],
                TransformerResponse::HTTP_CREATED,
                TransformerResponse::CREATE_SUCCESS_MESSAGE,
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
     * Show Id employee
     * 
     * @param $request
     * @return Response 
     * 
     */
    public function show($id)
    {
        try {
            $employee = $this->employeeRepository->show($id);
            return $this->transformerResponse->response(
                false,
                [
                    'employee' => $employee
                ],
                TransformerResponse::HTTP_OK,
                TransformerResponse::GET_SUCCESS_MESSAGE,
        );  
        } catch (QueryException $ex) {
            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_INTERNAL_SERVER_ERROR,
                TransformerResponse::INTERNAL_SERVER_ERROR_MESSAGE
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
     * update employee
     * 
     * 
     * @param $request
     * @return Response 
     */
    public function update($request,$id)
    {
        try {
            $data = $request->only(['email','name','position','company_id']);
            $employee = $this->employeeRepository->update($id,$data);
            if (empty($employee)) {
                return $this->transformerResponse->response(
                    true,
                    [],
                    TransformerResponse::HTTP_UNAUTHORIZED,
                    self::ID_NOT_EXISTS,
                );  
            }
            return $this->transformerResponse->response(
                false,
                [
                    'employee' => $employee
                ],
                TransformerResponse::HTTP_OK,
                TransformerResponse::UPDATE_SUCCESS_MESSAGE ,
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
     * delete employee
     * 
     * @param $request
     * @return Response 
     */
    public function delete($id)
    {
        try {
        $employee = $this->employeeRepository->delete($id);
        if (empty($employee)) return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_NOT_FOUND,
                self::ID_NOT_EXISTS
            );
            if (!$employee) return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_NO_CONTENT,
                self::DELETE_FAILED
            );
        return $this->transformerResponse->response(
            false,
            [
                'employee' => $employee
            ],
            TransformerResponse::HTTP_OK,
            TransformerResponse::DELETE_SUCCESS_MESSAGE,
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
     * get Employee List 
     * 
     * @param $request
     * @return Response 
     */
    public function getEmployeeList($company_id)
    { 
        try {  
            $employee = $this->employeeRepository->getEmployeeList($company_id);
            if(empty($employee)) return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_NOT_FOUND,
                TransformerResponse::NOT_FOUND_MESSAGE,
            );  
            return $this->transformerResponse->response(
                false,
                [
                    'employee' => $employee
                ],
                TransformerResponse::HTTP_OK,
                TransformerResponse::GET_SUCCESS_MESSAGE,
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
<?php
namespace App\Modules\Company\Services;

use App\Modules\Company\Controllers;
use App\Modules\Company\Repositories\CompanyRepository;
use App\Modules\Company\Requests\Create;
use App\Modules\Company\Requests\Update;
use App\Modules\Company\Services\Interfaces\CompanyServiceInterface;
use App\Modules\Company\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Helpers\TransformerResponse;
use Illuminate\Http\Response;

class CompanyService implements CompanyServiceInterface
{
    private $transformerResponse;
    private $companyRepository;
    const ID_NOT_EXISTS = 'ID_NOT_EXISTS';
    const DELETE_FAILED = 'DELETE_FAILED';

    public function __construct(
        TransformerResponse $transformerResponse,
        CompanyRepositoryInterface $companyRepository
    )
    {
        $this->transformerResponse = $transformerResponse;
        $this->companyRepository = $companyRepository;
    }
    /**
     * get all Company
     * 
     * @param $request
     * @return Response 
     */
    public function getAll()
    {    
        try {
            $company = $this->companyRepository->getAll();
            return $this->transformerResponse->response(
                false,
                [
                    'company' => $company
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
     * create Company
     * 
     * @param $request
     * @return Response 
     */
    public function create($request)
    {
        try {
            $validated = $request->validated();
            $company = $this->companyRepository->create($validated);
            return $this->transformerResponse->response(
                false,
                [
                    'company' => $company
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
     * Show Id Company
     * 
     * @param $request
     * @return Response 
     */
    public function show($id)
    {
        try {
            $company = $this->companyRepository->show($id);
            return $this->transformerResponse->response(
                false,
                [
                    'company' => $company
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
     * Update Company
     * 
     * @param $request
     * @return Response 
     */
    public function update($request,$id)
    {
        try {
            $data = $request->only(['name','address']);
            $company = $this->companyRepository->update($id,$data);
            if (empty($company)) return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_UNAUTHORIZED,
                self::ID_NOT_EXISTS,
            );  
            return $this->transformerResponse->response(
                false,
                [
                    'company' => $company
                ],
                TransformerResponse::HTTP_OK,
                TransformerResponse::UPDATE_SUCCESS_MESSAGE,
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
     * Delete Company
     * 
     * @param $request
     * @return Response 
     */
    public function delete($id)
    {
        try {
        $company = $this->companyRepository->delete($id);
        if (empty($company)) {
            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_NOT_FOUND,
                self::ID_NOT_EXISTS
            );
        }
            if (!$company) {
                return $this->transformerResponse->response(
                    true,
                    [],
                    TransformerResponse::HTTP_NO_CONTENT,
                    self::DELETE_FAILED
                );
            }     
        return $this->transformerResponse->response(
            false,
            [
                'company' => $company
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
}
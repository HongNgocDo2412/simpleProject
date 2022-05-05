<?php

namespace App\Modules\Company\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Company\Requests\CreateRequest;
use App\Modules\Company\Requests\UpdateRequest;
use App\Modules\Company\Services\CompanyService;
use App\Modules\Company\Services\Interfaces\CompanyServiceInterface;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CompanyController extends Controller 
{
    private  $companyService;

    public function __construct(CompanyServiceInterface $companyService)
    {
        $this->companyService = $companyService;
    }

    public function getAll()
    {
        return $this->companyService->getAll();
    }

    public function create(CreateRequest $request)
    {
        return $this->companyService->create($request);
    }

    public function show($id)
    {
        return $this->companyService->show($id);
    }

    public function update(UpdateRequest $request,$id)
    {
        return $this->companyService->update($request,$id);
    }

    public function destroy($id)
    {
        return $this->companyService->delete($id);
    }
}
<?php

namespace App\Modules\Employee\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Employee\Requests\CreateRequest;
use App\Modules\Employee\Requests\UpdateRequest;
use App\Modules\Employee\Services\EmployeeService;
use App\Modules\Employee\Services\Interfaces\EmployeeServiceInterface;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class EmployeeController extends Controller 
{
    private  $employeeService;

    public function __construct(EmployeeServiceInterface $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function getAll()
    {
        return $this->employeeService->getAll();
    }

    public function create(CreateRequest $request)
    {
        return $this->employeeService->create($request);
    }

    public function show($id)
    {
        return $this->employeeService->show($id);
    }

    public function update(UpdateRequest $request,$id)
    {
        return $this->employeeService->update($request,$id);
    }

    public function destroy($id)
    {
        return $this->employeeService->delete($id);
    }

    public function getEmployeeList($company_id)
    {
        return $this->employeeService->getEmployeeList($company_id);
    }
}
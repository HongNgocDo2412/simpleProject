<?php

namespace App\Modules\Employee\Services\Interfaces;

interface EmployeeServiceInterface
{
    public function getAll();
    public function create($request);
    public function show($id);
    public function update($request,$id);
    public function delete($id);
    public function getEmployeeList($company_id);
}
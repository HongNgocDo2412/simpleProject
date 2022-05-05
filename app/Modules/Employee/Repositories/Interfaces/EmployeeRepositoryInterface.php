<?php
namespace App\Modules\Employee\Repositories\Interfaces;
 
interface EmployeeRepositoryInterface 
{
    public function getAll();
    public function create(array $data);
    public function show($id);
    public function update($id, array $newData);
    public function delete($id);
    public function getEmployeeList($company_id);
}
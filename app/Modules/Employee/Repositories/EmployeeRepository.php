<?php

namespace App\Modules\Employee\Repositories;

use App\Modules\Employee\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Modules\Employee\Models\Employee;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    /**
     * getAll
     * 
     * @param $request
     * @return Response 
     */
    public function getAll()
    {
        return Employee::all();
    }
 /**
     * create
     * 
     * @param $request
     * @return Response 
     */
    public function create(array $data)
    {
        return Employee::create($data);
    }
      /**
     * show
     * 
     * @param $request
     * @return Response 
     */
    public function show($id)
    {
        return Employee::findOrFail($id);
    }
   /**
     * update
     * 
     * @param $request
     * @return Response 
     */
    public function update($id, array $data)
    {
        return Employee::where('id', $id)->update($data);
    }
   /**
     * delete
     * 
     * @param $request
     * @return Response 
     */
    public function delete($id)
    {
        return Employee::where('id', $id)->delete();
    }
  /**
     * getEmployeeList
     * 
     * @param $request
     * @return Response 
     */
    public function getEmployeeList($company_id)
    {
        return Employee::where('company_id',$company_id)->get();
    }
}
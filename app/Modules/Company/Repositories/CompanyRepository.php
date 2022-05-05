<?php

namespace App\Modules\Company\Repositories;

use App\Modules\Company\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Modules\Company\Models\Company;

class CompanyRepository implements CompanyRepositoryInterface
{
     /**
     * getAll
     * 
     * @param $request
     * @return Response 
     */
    public function getAll()
    {
        return Company::all();
    }
       /**
     * create
     * 
     * @param $request
     * @return Response 
     */
    public function create(array $data)
    {
        return Company::create($data);
    }
        /**
     * show
     * 
     * @param $request
     * @return Response 
     */
    public function show($id)
    {
        return Company::findOrFail($id);
    }
     /**
     * update
     * 
     * @param $request
     * @return Response 
     */
    public function update($id, array $data)
    {
       return Company::where('id', $id)->update($data);
    }
   /**
     * delete
     * 
     * @param $request
     * @return Response 
     */
    public function delete($id)
    {
        return Company::where('id', $id)->delete();
    }
}
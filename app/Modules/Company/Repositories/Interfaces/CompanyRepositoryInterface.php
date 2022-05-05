<?php
namespace App\Modules\Company\Repositories\Interfaces;
 
interface CompanyRepositoryInterface 
{
    public function getAll();
    public function create(array $data);
    public function show($id);
    public function update($id, array $newData);
    public function delete($id);
}
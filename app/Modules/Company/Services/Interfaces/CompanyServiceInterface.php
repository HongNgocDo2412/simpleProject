<?php

namespace App\Modules\Company\Services\Interfaces;

interface CompanyServiceInterface
{
    public function getAll();
    public function create($request);
    public function show($id);
    public function update($request,$id);
    public function delete($id);
}
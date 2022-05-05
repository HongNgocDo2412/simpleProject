<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\Create;
use App\Http\Requests\Company\Update;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\QueryException;
class CompanyController extends Controller
{
    public function index()
    {
        try {
            $company = Company::all();
            return response()->json(['company' => $company],200);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['errors' => $ex->getMessage()],404);
        } catch (QueryException $ex) {
            return response()->json(['errors' => $ex->getMessage()],500);
        }
    }

    public function create(Create $request)
    {
        try {
            $validated = $request->validated();
            $company = Company::create($validated);
            return response()->json(['company' => $company ,'message' => 'created successfully'],201);
        } catch (QueryException $ex) {
            return response()->json(['errors' => $ex->getMessage()],500);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['errors' => $ex->getMessage()],404);
        }
    }

    public function show($id)
    {
        try {
            $company = Company::find($id);
            if (empty($company))     return response()->json('Data not found', 404); 

            return response()->json(['company' => $company],200);
        } catch (QueryException $ex) {
            return response()->json(['errors' => $ex->getMessage()],500);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['errors' => $ex->getMessage()],404);
        }
    }

    public function update(Update $request,$id)
    { 
        try {
            $validated = $request->validated();
            $company = Company::find($id);
            if (empty($company))   return response()->json(['message'=> 'Id do not exists'],404);

                $company->name = $validated['name'];
                $company->address = $validated['address'];
                $company->save();
                return response()->json(['company' => $company ,'message' => 'updated successfully'],200);
            
        } catch (QueryException $ex) {
            return response()->json(['errors' => $ex->getMessage()],500);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['errors' => $ex->getMessage()],404);
        }
       
    }

    public function destroy($id)
    {
        try {
            $company = Company::find($id);
            if (empty($company))    return  response()->json(['message' =>'Id do not exists'],404);
            if (!$company->delete())    return response()->json(['message' => 'Delete failed'],204);
            return response()->json(['message' => 'Company deleted successfully'],200);
        } catch (QueryException $ex) {
            return response()->json(['errors' => $ex->getMessage()],500);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['errors' => $ex->getMessage()],404);
        }  
    }
}

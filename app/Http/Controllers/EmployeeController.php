<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Employee\Create;
use App\Http\Requests\Employee\Update;
use App\Models\Employee;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\QueryException;
class EmployeeController extends Controller
{
    public function index()
    {
        try {
            $employee = Employee::all();
            return response()->json(['employee' => $employee],200);
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
            $employee = Employee::create($validated);
            return response()->json(['employee' => $employee ,'message' => 'created successfully'],201);
        } catch (QueryException $ex) {
            return response()->json(['errors' => $ex->getMessage()],500);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['errors' => $ex->getMessage()],404);
        }
    }

    public function show ($id)
    {
        try {
            $employee = Employee::find($id);
            if (empty($employee))     return response()->json('Data not found', 404); 
            return response()->json(['employee' => $employee],200);
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
            $employee = Employee::find($id);
            if (empty($employee))  return response()->json(['message'=> 'Id do not exists'],401);
                $employee->email = $validated['email'];
                $employee->name = $validated['name'];
                $employee->position = $validated['position'];
                $employee->company_id = $validated['company_id'];
                $employee->save();
                return response()->json(['employee' => $employee ,'message' => 'updated successfully'],200);
        } catch (QueryException $ex) {
            return response()->json(['errors' => $ex->getMessage()],500);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['errors' => $ex->getMessage()],404);
        } 
    }

    public function destroy($id)
    {
        try {    
            $employee = Employee::find($id);
            if (empty($employee))    return  response()->json(['message' =>'Id do not exists'],404);
            if (!$employee->delete())    return response()->json(['message' => 'Delete failed'],204);
            return response()->json(['message' => 'Employee deleted successfully'],200);
        } catch (QueryException $ex) {
            return response()->json(['errors' => $ex->getMessage()],500);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['errors' => $ex->getMessage()],404);
        }  
    }

    public function getEmployeeList($company_id)
    {
        try {
             $employee = Employee::where('company_id',$company_id)->get();
             if ($employee->isEmpty())  {
                return response()->json(['errors' => 'id do not exists'],404);
             }
                return response()->json(['employee' => $employee],200);
        } catch (QueryException $ex) {
            return response()->json(['errors' => $ex->getMessage()],500);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['errors' => $ex->getMessage()],404);
        }  
    }

    
}

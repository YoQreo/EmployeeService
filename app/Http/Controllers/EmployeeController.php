<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    /**
     * Show All employees
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        return $this->successResponse($employees);
    }

    /**
     * Create An employee
     *
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $rules=[
            'names' => 'required|unique:employees',
            'surname' => 'required|unique:employees',
        ];
        
        
        $this->validate($request,$rules);

        $employee = Employee::create($request->all());
        return $this->successResponse($employee,Response::HTTP_CREATED);
       
    }

    /**
     * Get An employee
     *
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {   
        $employee = Employee::findOrFail($id);

        return $this->successResponse($employee);
    }

        /**
     * Create An employee
     *
     * @return Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {   
        $employee = Employee::findOrFail($id);

        $rules=[
            'names' => "required|unique:employees,names,$id",
            'surname' => "required|unique:employees,surname,$id"
        ];
        
        
        $this->validate($request,$rules);

        $employee->fill($request->all());

        if($employee->isClean()){
            return $this->errorResponse('At least one value must change',
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $employee->save();

        return $this->successResponse($employee,Response::HTTP_CREATED);
       
    }
    
    /**
     * Delete An employee
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $employee = Employee::findOrFail($id);

        $employee->delete();

        return $this->successResponse($employee);
    }
        
    //
}

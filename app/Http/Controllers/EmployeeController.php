<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\EmployeeModel;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('index');
    }

    public function getEmployee(){
        $employees = EmployeeModel::all()->toArray();
        return response()->json([
            'employees'=>$employees,
        ]);
    }

    public function addEmployee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'salary' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }else{
            EmployeeModel::create([
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'salary' => $request->input('salary'),
            ]);

            return response()->json([
                'status'=>200,
                'message'=>'Employee Added Successfully'
            ]);
        }
        

    }

    public function getEmployeeById($id)
    {
        $employee = EmployeeModel::find($id);
        if ($employee) {
            return response()->json([
                'status' => 200,
                'employee' => $employee
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=> "Employee Not Found"
            ]);
        }
    }

    public function updateEmployeeById(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'salary' => 'required',

        ]);
        

        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }else{
            $employee = EmployeeModel::find($id);
            if ($employee) {
                $employee->update([
                    'name' => $request->input('name'),
                    'address' => $request->input('address'),
                    'salary' => $request->input('salary'),
                ]);
                return response()->json([
                    'status'=>200,
                    'message'=>'Employee Updated Successfully'
                ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=> "Employee Not Found"
                ]);
            }
        }
    }

    public function deleteEmployeeById($id)
    {
        $employee = EmployeeModel::find($id);
        $employee->delete();
        return response()->json([
            'status'=>200,
            'message'=>"Employee Deleted"
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeDepartment;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Employee\EmployeeDepartment\DepartmentStore;
use App\Http\Requests\Employee\EmployeeDepartment\DepartmentUpdate;
use App\Http\Resources\Employee\EmployeeDepartment\EmployeeDepartmentResource;
use App\Http\Resources\Employee\EmployeeDepartment\EmployeeDepartmentCollection;

class EmployeeDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = new EmployeeDepartmentCollection(EmployeeDepartment::paginate(10));
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentStore $request)
    {
        $validated = $request->validated();
        $department = $validated["department"];
        $description = isset($validated["description"])
            ? $validated["description"]
            : "";
        $data = EmployeeDepartment::create($validated);

        if ($data == true) {
            return response()->json(
                ["message" => "Employee Department Created Successfully"],
                200
            );
        } else {
            return response()->json(
                [
                    "message" =>
                        "Error Occuring While creating Department! Please Try Again",
                ],
                503
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (EmployeeDepartment::where("id", $id)->exists()) {
            $data = new EmployeeDepartmentResource(
                EmployeeDepartment::find($id)
            );
            return response()->json($data, 200);
        } else {
            return response()->json(
                ["error" => "Not Found Employee Department"],
                404
            );
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentUpdate $request, $id)
    {
        $validated = $request->validated();
        $department = $validated["department"];
        $description = isset($validated["description"])
            ? $validated["description"]
            : "";
        if(EmployeeDepartment::where("id", $id)->exists()){

            $data = EmployeeDepartment::where('id', $id)->update($validated);
        }else{
            return response()->json(
                ["error" => "Not Found Employee Department"],
                404
            );
        }
        

        if ($data == true) {
            return response()->json(
                ["message" => "Employee Department Update Successfully"],
                200
            );
        } else {
            return response()->json(
                [
                    "message" =>
                        "Error Occuring While Updating Department! Please Try Again",
                ],
                503
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (EmployeeDepartment::where("id", $id)->exists()) {
            EmployeeDepartment::find($id)->delete();

            return response()->json(
                ["success" => "Employee Department deleted Successfully"],
                200
            );
        } else {
            return response()->json(
                ["error" => "Not Found Employee Department"],
                404
            );
        }
    }
    
}

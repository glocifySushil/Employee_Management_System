<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeDesignation;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Employee\EmployeeDesignation\DesignationStore;
use App\Http\Requests\Employee\EmployeeDesignation\DesignationUpdate;
use App\Http\Resources\Employee\EmployeeDesignation\EmployeeDesignationResource;
use App\Http\Resources\Employee\EmployeeDesignation\EmployeeDesignationCollection;

class EmployeeDesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = new EmployeeDesignationCollection(EmployeeDesignation::paginate(10));
        return response($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DesignationStore $request)
    {
        $validated = $request->validated();
        $department = $validated["designation"];
        $description = isset($validated["description"])
            ? $validated["description"]
            : "";
        $data = EmployeeDesignation::create($validated);

        if ($data == true) {
            return response()->json(
                ["message" => "Employee Designation Created Successfully"],
                200
            );
        } else {
            return response()->json(
                [
                    "message" =>
                        "Error Occuring While creating Designation! Please Try Again",
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
        if (EmployeeDesignation::where("id", $id)->exists()) {
            $data = new EmployeeDesignationResource(
                EmployeeDesignation::find($id)
            );
            return response()->json($data, 200);
        } else {
            return response()->json(
                ["error" => "Not Found Employee Designation"],
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
    public function update(DesignationUpdate $request, $id)
    {
        $validated = $request->validated();
        $department = $validated["designation"];
        $description = isset($validated["description"])
            ? $validated["description"]
            : "";
        if(EmployeeDesignation::where("id", $id)->exists()){

            $data = EmployeeDesignation::where('id', $id)->update($validated);
        }else{
            return response()->json(
                ["error" => "Not Found Employee Designation"],
                404
            );
        }
        

        if ($data == true) {
            return response()->json(
                ["message" => "Employee Designation Update Successfully"],
                200
            );
        } else {
            return response()->json(
                [
                    "message" =>
                        "Error Occuring While Updating Designation! Please Try Again",
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
        if (EmployeeDesignation::where("id", $id)->exists()) {
            EmployeeDesignation::find($id)->delete();

            return response()->json(
                ["success" => "Employee Designation deleted Successfully"],
                200
            );
        } else {
            return response()->json(
                ["error" => "Not Found Employee Designation"],
                404
            );
        }
    }
}

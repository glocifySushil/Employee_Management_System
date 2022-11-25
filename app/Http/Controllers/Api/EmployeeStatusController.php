<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeStatus;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Employee\EmployeeStatus\StatusStore;
use App\Http\Requests\Employee\EmployeeStatus\StatusUpdate;
use App\Http\Resources\Employee\EmployeeStatus\EmployeeStatusResource;
use App\Http\Resources\Employee\EmployeeStatus\EmployeeStatusCollection;

class EmployeeStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = new EmployeeStatusCollection(EmployeeStatus::paginate(10));
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StatusStore $request)
    {
        $validated = $request->validated();
        $status = $validated["status"];
        $data = EmployeeStatus::create($validated);
        if ($data == true) {
            return response()->json(
                ["message" => "Employee Status Created Successfully"],
                200
            );
        } else {
            return response()->json(
                [
                    "message" =>
                        "Error Occuring While creating Employee Status! Please Try Again",
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
        if (EmployeeStatus::where("id", $id)->exists()) {
            $data = new EmployeeStatusResource(
                EmployeeStatus::find($id)
            );
            return response()->json($data, 200);
        } else {
            return response()->json(
                ["error" => "Not Found Employee Status"],
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
    public function update(StatusUpdate $request, $id)
    {
        $validated = $request->validated();
        $status = $validated["status"];
        if(EmployeeStatus::where("id", $id)->exists()){

            $data = EmployeeStatus::where('id', $id)->update($validated);
        }else{
            return response()->json(
                ["error" => "Not Found Employee Status"],
                404
            );
        }
        

        if ($data == true) {
            return response()->json(
                ["message" => "Employee Status Update Successfully"],
                200
            );
        } else {
            return response()->json(
                [
                    "message" =>
                        "Error Occuring While Updating Employee Status! Please Try Again",
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
        if (EmployeeStatus::where("id", $id)->exists()) {
            EmployeeStatus::find($id)->delete();

            return response()->json(
                ["success" => "Employee Status deleted Successfully"],
                200
            );
        } else {
            return response()->json(
                ["error" => "Not Found Employee Status"],
                404
            );
        }
    }
}

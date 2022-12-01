<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeAttendence;
use App\Http\Requests\Employee\EmployeeAttendence\AttendenceStore;
use App\Http\Requests\Employee\EmployeeAttendence\AttendenceUpdate;
use App\Http\Resources\Employee\EmployeeAttendence\AttendenceCollection;
use App\Http\Resources\Employee\EmployeeAttendence\AttendenceResource;

class EmployeeAttendenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $data = new AttendenceCollection(EmployeeAttendence::orderBy('id', 'DESC')->paginate(10));
        return response($data,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttendenceStore $request)
    {
        $validated = $request->validated();
        $data = EmployeeAttendence::create($validated);
        if ($data == true) {
            return response()->json(
                ["message" => "Puch In  Successfully"],
                200
            );
        } else {
            return response()->json(
                [
                    "message" =>
                        "Error Occuring While Added Attendence! Please Try Again",
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
        if (EmployeeAttendence::where("id", $id)->exists()) {
            $data = new AttendenceResource(
                EmployeeAttendence::find($id)
            );
            return response()->json($data, 200);
        } else {
            return response()->json(
                ["error" => "Not Data Found "],
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
    public function update(AttendenceUpdate $request, $id)
    {
        $validated = $request->all();
        unset($validated['_method']);
        $data = EmployeeAttendence::where('id',$id)->update($validated);
        if ($data == true) {
            return response()->json(
                ["message" => "Punch Out Successfully"],
                200
            );
        } else {
            return response()->json(
                [
                    "message" =>
                        "Error Occuring While Update Employee! Please Try Again",
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
        if (EmployeeAttendence::where("id", $id)->exists()) {
            EmployeeAttendence::find($id)->delete();

            return response()->json(
                ["success" => "Attendence deleted Successfully"],
                200
            );
        } else {
            return response()->json(
                ["error" => "Attendence Entry Not Found "],
                404
            );
        }
    }
}

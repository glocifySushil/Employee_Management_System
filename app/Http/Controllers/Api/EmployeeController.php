<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\EmployeeStatus;
use App\Models\EmployeeDesignation;
use App\Models\EmployeeDepartment;
use App\Http\Requests\Employee\EmployeeStore;
use App\Http\Requests\Employee\EmployeeUpdate;
use App\Http\Resources\Employee\EmployeeResource;
use App\Http\Resources\Employee\EmployeeCollection;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $data = new EmployeeCollection(User::orderBy('id', 'DESC')->paginate(10));
        return response($data,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeStore $request)
    {
        $validated = $request->validated();
        //echo "<pre>"; print_r($request->all()); die;
        $file = $this->storeImage($validated['profile_picture']);
        unset($validated['profile_picture']);
        $validated['profile_picture'] = $file;
        $validated['password'] = Hash::make($validated['password']);
        $data = User::create($validated);
        if ($data == true) {
            return response()->json(
                ["message" => "Employee Added Successfully"],
                200
            );
        } else {
            return response()->json(
                [
                    "message" =>
                        "Error Occuring While Added Employee! Please Try Again",
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
        if (User::where("id", $id)->exists()) {
            $data = new EmployeeResource(
                User::find($id)
            );
            return response()->json($data, 200);
        } else {
            return response()->json(
                ["error" => "Not Found Employee"],
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
    public function update(Request $request, $id)
    {
        $validated = $request->all();
        if(isset($validated['profile_picture'])){
            $file = $this->storeImage($validated['profile_picture']);
        }
        unset($validated['profile_picture']);
        unset($validated['_method']);
        $validated['profile_picture'] = $file;
        if(isset($validated['password'])){
            $validated['password'] = Hash::make($validated['password']);
        }
        
        $data = User::where('id',$id)->update($validated);
        if ($data == true) {
            return response()->json(
                ["message" => "Employee Update Successfully"],
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

    public function storeImage($image)
    {
        $fileNameWithExt = $image->getClientOriginalName();
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        $extension = $image->getClientOriginalExtension();
        $fileNameToStore = $fileName.'_'.time().'.'.$extension;
        $image->move(public_path('employee/profileImages'), $fileNameToStore);
        return env('APP_URL').'/employee/profileImages/'. $fileNameToStore;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (User::where("id", $id)->exists()) {
            User::find($id)->delete();

            return response()->json(
                ["success" => "Employee deleted Successfully"],
                200
            );
        } else {
            return response()->json(
                ["error" => "Not Found Employee"],
                404
            );
        }
    }
        
        
}
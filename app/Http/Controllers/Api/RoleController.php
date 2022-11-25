<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Http\Requests\Employee\Role\RoleStore;
use App\Http\Requests\Employee\Role\RoleUpdate;
use App\Http\Resources\Employee\Role\RoleResource;
use App\Http\Resources\Employee\Role\RoleCollection;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = new RoleCollection(Role::paginate(10));
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStore $request)
    {
        $validated = $request->validated();
        $name = $validated["name"];
        $data = Role::create($validated);
        if ($data == true) {
            return response()->json(
                ["message" => "Role Created Successfully"],
                200
            );
        } else {
            return response()->json(
                [
                    "message" =>
                        "Error Occuring While creating Role! Please Try Again",
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
        if (Role::where("id", $id)->exists()) {
            $data = new RoleResource(
                Role::find($id)
            );
            return response()->json($data, 200);
        } else {
            return response()->json(
                ["error" => "Not Found Role"],
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
    public function update(RoleUpdate $request, $id)
    {
        $validated = $request->validated();
        $name = $validated["name"];
        if(Role::where("id", $id)->exists()){

            $data = Role::where('id', $id)->update($validated);
        }else{
            return response()->json(
                ["error" => "Not Found Role"],
                404
            );
        }
        

        if ($data == true) {
            return response()->json(
                ["message" => "Role Update Successfully"],
                200
            );
        } else {
            return response()->json(
                [
                    "message" =>
                        "Error Occuring While Updating Role! Please Try Again",
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
        if (Role::where("id", $id)->exists()) {
            Role::find($id)->delete();

            return response()->json(
                ["success" => "Role deleted Successfully"],
                200
            );
        } else {
            return response()->json(
                ["error" => "Not Found Role Status"],
                404
            );
        }
    }
}

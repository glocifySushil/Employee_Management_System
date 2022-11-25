<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeDocument;
use App\Http\Requests\Employee\EmployeeDocuments\DocumentsStore; 
use App\Http\Requests\Employee\EmployeeDocuments\DocumentsUpdate;
use App\Http\Resources\Employee\EmployeeDocuments\DocumentsResource;
use App\Http\Resources\Employee\EmployeeDocuments\DocumentsCollection;
class EmployeeDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if (EmployeeDocument::where("user_id", $id)->exists()) {
            $data = new DocumentCollection(EmployeeDocument::where('user_id',$id)->get());
            return response()->json($data, 200);
        } else {
            return response()->json(
                ["error" => "Not Found Documents"],
                404
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentsStore $request, $id)
    {
        $validated = $request->validated();
        $file = $validated['attachment'];
        $fileNameWithExt = $file->getClientOriginalName();
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileNameToStore = $fileName.'_'.time().'.'.$extension;
        $file->move(public_path('employee/documents'), $fileNameToStore);
        unset($validated['attachment']);
        $validated['attachment'] = $fileNameToStore;
        $validated['user_id'] = $id;
       //echo "<pre>"; print_r($validated); die;
        $data = EmployeeDocument::create($validated);
        if ($data == true) {
            return response()->json(
                ["message" => "Document Added Successfully"],
                200
            );
        } else {
            return response()->json(
                [
                    "message" =>
                        "Error Occuring While Adding Document! Please Try Again",
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
    public function show(Request $request, $id)
    {
        $uri = $request->path();
        $docId = array_slice(explode('/', $uri), -1)[0];

        if (EmployeeDocument::where("id", $docId)->exists()) {
            $data = new DocumentResource(EmployeeDocument::find($docId));
            return response($data, 200);
        } else {
            return response()->json(
                ["error" => "Not Found Documents"],
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
    public function update(DocumentUpdate $request, $id)
    {
        $uri = $request->path();
        $docId = array_slice(explode('/', $uri), -1)[0];
        if (EmployeeDocument::where("id", $docId)->exists()) {
            $validated = $request->all();
            $file = $validated['attachment'];
            $fileNameWithExt = $file->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $file->move(public_path('employee/documents'), $fileNameToStore);
            unset($validated['attachment']);
            unset($validated['_method']);
            $validated['attachment'] = $fileNameToStore;
            $data = EmployeeDocument::where('id',$docId)->update($validated);
            return response(['success'=> 'Document has been update'], 200);
        } else {
            return response()->json(
                ["error" => "Not Found Documents"],
                404
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
        $uri = $request->path();
        $docId = array_slice(explode('/', $uri), -1)[0];
        if (EmployeeDocument::where("id", $id)->exists()) {
            EmployeeDocument::find($id)->delete();
            return response()->json(
                ["success" => "Document deleted Successfully"],
                200
            );
        } else {
            return response()->json(
                ["error" => "Not Found Document"],
                404
            );
        }                      
    }
}

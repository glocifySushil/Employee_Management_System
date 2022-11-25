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
use App\Http\Resources\UserResource;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\Employee\EmployeeCollection;
use App\Http\Requests\Employee\EmployeeStoreRequest;
use App\Http\Requests\Employee\EmployeeLoginRequest;

class AuthController extends Controller
{

    public function login(Request $request)
    {

        $validated = $request->all();
        if(! auth()->attempt($validated)){
            return response()->json(['error' => 'Invalid Token'], 401);
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        $user = auth()->user();
        $role = $user->role_id;
        $userData = User::where('id', $user->id)->get();

        if(in_array($role, Role::Admin)){

            $EmployeeStatus = EmployeeStatus::all();
            $EmployeeDesignation = EmployeeDesignation::all();
            $EmployeeDepartment = EmployeeDepartment::all();
            $allUser = new EmployeeCollection(User::paginate(10));
            $allRoles = Role::all();

            $data = [
                'allEmployeeStatus' => $EmployeeStatus,
                'allEmployeeDesignations' => $EmployeeDesignation,
                'allEmployeeDepartments' => $EmployeeDepartment,
                'allEmployees' => $allUser,
                'allRoles' => $allRoles,
                'personalUserData' => $userData,
                'access_token' => $accessToken,
                'success' => 'Employee Login Successfully',
            ];

            return response($data, 200);
        }
        else{

            $data = [
                'personalUserData' => $userData,
                'access_token' => $accessToken,
                'success' => 'Employee Login Successfully',
            ];

            return response($data, 200);

        }

    }

    public function logout (Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
    
}
<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ApiController extends Controller
{

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'message' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                return response()->json(['status' => 200, 'message' => 'Logged in successfully', 'data' => $user]);
            } else {
                return response()->json(['status' => 400, 'message' => 'Invalid credentials'], 400);
            }
        } else {
            return response()->json(['status' => 400, 'message' => 'User not found'], 400);
        }
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'name' => 'required',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'message' => $validator->errors()], 422);
        }
        $emailExsits = User::where('email', $request->email)->first();
        if($emailExsits){
            return response()->json(['status' => 400, 'message' => "Email already exists, Try another email"], 400);
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->user_type = $request->role;
        $user->save();
        return response()->json(['status' => 200, 'message' => "Registered Successfully", 'data'=>$user], 200);
    }

    public function getUser($id){
        $user = User::where('id', $id)->first();
        return response()->json(['status' => 200, 'message' => "User retrieved successfully", 'data'=>$user], 200);
    }

    public function updateUser($id, Request $request){
        $decodedValue = json_decode($request['userDetails']);
        $user = User::where('id', $id)->first();
        $user->name = $decodedValue->name;
        $user->email = $decodedValue->email;
        if(isset($decodedValue->password) && !empty($decodedValue->password)){
            $user->password = $decodedValue->password;
        }
        $user->save();
        return response()->json(['status' => 200, 'message' => "User Updated Successfully", 'data'=>$user], 200);
    }
    public function updateUsers($id, Request $request){
    
        $user = User::where('id', $id)->first();
        // print_r($user);die();
        $user->name = $request->name;
        $user->email = $request->email;
        if(isset($request->password)){
            $user->password = $request->password;
        }
        $user->save();
        return response()->json(['status' => 200, 'message' => "User Updated Successfully", 'data'=>$user], 200);
    }
    

    public function allEmployees(Request $request){
        $user = User::where('user_type','!=','admin')->get();
        return response()->json(['status'=>200,'message'=>'All users','data'=>$user]);
    }
}

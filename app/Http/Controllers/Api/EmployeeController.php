<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
  //REGISTER
    public function register(Request $request)
    {
      //validate
      $fields = $request->validate([
        'name' => 'required',
        'email' =>'required|email|unique:employees',
        'age' => 'required',
        'phone_no' => 'required',
        'password' => 'required|min:8'
        ]);
      
      //insert to database
      $employee = Employee::create([
        'name' => $fields['name'],
        'email' => $fields['email'],
        'age' => $fields['age'],
        'phone_no' => $fields['phone_no'],
        'password' => Hash::make($fields['password'])
        ]);
      
      //generating token  
      $token = $employee->createToken('abc')->plainTextToken;
      
      //return data to json
      return response()->json([
        'message' => 'registered successfully',
        'data' => $employee,
        'token' => $token
        ]);
    }
    
    //login
    public function login(Request $request)
    {
      //validate for logging in
      $fields = $request->only('email','password');
      if(!Auth::attempt($fields))
      {
        return response()->json([
          'message' => 'failed to logging in'
          ]);
      }
      
      //generate token
      $employee = Employee::where('email', $fields['email'])->first();
      $token = $employee->createToken('abc')->plainTextToken;
      
      //return response json
      return response()->json([
        'message' => 'logged in',
        'token' => $token
        ]);
    }
    
    //logout
    public function logout()
    {
      auth()->user()->tokens()->delete();
      return response()->json([
        'message' => 'logged out'
        ]);
    }
}

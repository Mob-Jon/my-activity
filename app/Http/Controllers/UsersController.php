<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    
    public function LoginForm() {
        return view('login');
    }

    public function RegisterForm() {
        return view('register');
    }

    public function Register(Request $request) 
    {

        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $response = [];

        DB::beginTransaction();

        try {
            //save
            $data = $request->all();
            $data["type"] = "user";
            $data["password"] = Hash::make($data["password"]);

            $user = User::create($data);

            $response["success"] = true;
            $response["Message: "] = "Successfully inserted a user!";
            $response["Last inserted Id: "] = $user->id;
            $response["email"] = $user->email;
            $response["code"] = 201;
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $response["success"] = false;
            $response["errors"] = ["message" => "The user was not created!" . $e];
            $response["code"] = 400;
        }

        return response($response, $response["code"]);
    }

    public function Login(Request $request) 
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email','password');

        $user = User::where('email', $credentials['email'])->first();

        if (Auth::attempt($credentials)) {

            session(['type' => $user->type]);

            return response()->json(['success' => true, 'status' => 200, 'redirect' => route('accounts'), 'type' => $user->type]);
        }

        return response()->json(['success' => false, 'status' => 404, 'message' => 'Invalid Credentials', 'statusText' => "User not found"]);
    }

    public function Logout(Request $request)
    {
        Auth::logout();

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect('/');
    }

    public function getAccountById(Request $request){

        $userId = $request->id;

        $userInfo = DB::select('select * from users where id = :id', ['id' => $userId]);
 
        return response()->json(['success' => true, 'status' => 200, 'userInfo' => $userInfo]);
    }

    public function updateAccountById(Request $request){

        
        $userId = $request->id;
        
        $userInfo = User::find($userId);

        $original = $userInfo->getOriginal();
        
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'email' => 'required',
        ]);

        $userInfo->fill($request->all());

        // Check if any attributes have been modified
        if ($userInfo->isDirty()) {
            $userInfo->save();
            return response()->json(['success' => true, 'status' => 200, 'message' => 'Successfully updated an account']);
        }else{
            return response()->json(['success' => true, 'status' => 200, 'message' => 'No changes detected']);
        }

    }

}

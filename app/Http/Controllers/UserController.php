<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Mail\PasswordReset;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $inputs = $request->validate([
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required'],
            'username' => ['required'],
            'phone' => ['unique:users'],
            'first_name' => [],
            'last_name' => [],
        ]);
        $inputs['privilege'] = 3;
        $inputs['password'] = Hash::make($inputs['password']);
        if ($user = User::create($inputs)) {
            $user_api_token = $user->createToken('token')->plainTextToken;
            $user->update(['api_token' => $user_api_token]);
            return response()->json(["message" => "User registered"], 201);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            return response()->json(["data" => ["api_token" => $request->user()->api_token]], 200);
        }
        return response()->json(["message" => "Incorrect credentials"], 400);
    }

    public function index(Request $request)
    {
        return response()->json(["data" => new UserResource($request->user())], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateEmail(Request $request)
    {
        $inputs = $request->validate([
            'email' => ['email', 'required', 'unique:users']
        ]);
        $request->user()->update($inputs);
        return response()->json(["message" => "Email updated"], 202);
    }

    public function updatePwd(Request $request)
    {
        $inputs = $request->validate([
            'current_password' => ['required'],
            'password' => ['required']
        ]);
        if (Hash::check($inputs['current_password'], $request->user()->password)) $request->user()->update(['password' => Hash::make($inputs['password'])]);
        else return response()->json(['message' => "Bad current password"], 400);
        return response()->json(["message" => "Password updated"], 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->user()->delete();
        return response()->json(['message' => 'User deleted'], 200);
    }

    public function pwdreset(Request $request) {
        $inputs = $request->validate([
            'email' => ['required', 'email']
        ]);
        $user = $request->user();
        $new_password = Str::random(20);
        try {
            $user->update(['password' => Hash::make($new_password)]);
            Mail::to($inputs['email'])->send(new PasswordReset($new_password));
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
        return response()->json(['message' => "Email send"], 200);
    }
}

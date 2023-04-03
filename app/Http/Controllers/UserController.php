<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        if (User::where("email", $request->input("email"))->first()) {
            return response()->json(["state" => "Email allready used"], 400);
        }
        if (User::create([
            'name' => $request->input('name'),
            'password' => $request->input('password'),
            'email' => $request->input('email'),
            'api_token' => Str::random(20),
            'privilege' => 3
        ])) {
            return response()->json(["state" => "OK"], 201);
        }
    }

    public function login(Request $request)
    {
        if ($user = User::where('email', $request->input('email'))->where('password', $request->input('password'))->first()) {
            return response()->json(["data" => new UserResource($user), 'state' => 'OK'], 200);
        }
        else {
            return response()->json(["state" => "Bad username or password"], 400);
        }
    }

    public function index(Request $request)
    {
        if ($user = User::where('api_token', $request->input('api_token'))->first()) {
            return response()->json(["data" => new UserResource($user), 'state' => 'OK'], 200);
        }
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
        if (User::where("email", $request->input("email"))->first()) {
            return response()->json(["state" => "Email allready used"], 400);
        }
        if ($user = User::where("api_token", $request->input("api_token"))->first()) {
            $user->update([
                "email" => $request->input("email")
            ]);
            return response()->json(["state" => "OK"], 202);
        }
    }

    public function updatePwd(Request $request, User $user)
    {
        if ($user = User::where('api_token', $request->input('api_token'))->where('password', $request->input('current_password'))->first()) {
            $user->update([
                "password" => $request->input("password")
            ]);
            return response()->json(["state" => "OK"], 202);
        }
        else {
            return response()->json(["state" => "Bad api token or password"], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($getuser = User::where("api_token", $request->input("api_token"))->first()) {
            return response()->json(["state" => "OK"], 202);
            $getuser->delete();
        }
        else {
            return response()->json(["state" => "Invalid api_token"], 400);
        }
    }


}

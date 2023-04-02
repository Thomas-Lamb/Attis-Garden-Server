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
            'api_token' => Str::random(20)
        ])) {
            return response()->json(["created" => TRUE], 201);
        }
    }

    public function login(Request $request)
    {
        if ($user = User::where('name', $request->input('name'))->where('password', $request->input('password'))->first()) {
            return response()->json(new UserResource($user), 202);
        }
        else {
            return response()->json(["state" => "Bad username or password"], 400);
        }
    }

    public function index(Request $request)
    {
        if ($user = User::where('api_token', $request->input('api_token'))->first()) {
            return response()->json(new UserResource($user), 202);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (User::where("email", $request->input("email"))->first()) {
            return response()->json(["state" => "Email allready used"], 400);
        }
        if ($request->input('password')) {
            return response()->json(["state" => "You need to use the /api/user/pwd route to change the password"], 400);
        }
        if ($user = User::where("api_token", $request->input("api_token"))->first()) {
            $user->update($request->all());
            return response()->json([], 204);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user, Request $request)
    {
        if ($getuser = User::where("id", $user)->first()) {
            if ($getuser->api_token == $request->input("api_token")) {
                return response()->json(["state" => "the user \"" . $getuser->name . "\" has been deleted"], 202);
                $getuser->delete();
            }
            else {
                return response()->json(["state" => "Bad api token or id"], 400);
            }
        }
        else {
            return response()->json(["state" => "Bad api token or id"], 400);
        }
    }

    public function changeMdp(Request $request, User $user)
    {
        if ($user = User::where('api_token', $request->input('api_token'))->where('password', $request->input('current_password'))->first()) {
            $user->update($request->all());
            return response()->json(["state" => "Pwd changed"], 202);
        }
        else {
            return response()->json(["state" => "Bad api token or password"], 400);
        }
    }
}

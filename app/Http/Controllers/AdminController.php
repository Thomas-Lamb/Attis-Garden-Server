<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        return response()->json([
            'data' => UserResource::collection($users),
            'state' => 'ok',
        ], 200);
    }

    public function update(Request $request)
    {
        $admin = User::where('api_token', $request->input('api_token'))->first();
        if ($user = User::where('id', $request->input('user_id'))->first()) {
            if ($admin->privilege < $user->privilege) {
                $user->update([
                    "name" => $request->input('user_name', $user->name),
                    "password" => $request->input('user_password', $user->password),
                    "email" => $request->input('user_email', $user->email),
                ]);
                return response()->json([
                    'state' => 'ok',
                ], 202);
            }
            else {
                return response()->json([
                    'state' => 'you dont have the required privilege',
                ], 400);
            }
        }
        else {
            return response()->json([
                'state' => 'id does not exist',
            ], 400);
        }
    }

    public function destroy(Request $request)
    {
        if ($user = User::where('id', $request->input('user_id'))->first()) {
            $user->delete();
            return response()->json([
                'state' => 'ok',
            ], 202);
        }
        else {
            return response()->json([
                'state' => 'id does not exist',
            ], 400);
        }
    }
}

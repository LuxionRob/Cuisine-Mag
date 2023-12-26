<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }

    public function show(User $user)
    {
        $user->load('contacts.location');
        return response()->json($user);
    }
    public function destroy(User $user)
    {
        $res = $user;
        DB::transaction(function () use ($user) {
            $user->load('contacts');
            $user->contacts()->delete();
            $user->delete();
        });
        return response()->json($res);
    }
}

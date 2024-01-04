<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function post(Request $request)
    {        
        $validatedData = $request->validate([
            'name' =>'required|string|max:255',
            'email' =>'required|string',
            'password' =>'required|string'            
        ]);

        $user = User::create($validatedData);

        return response()->json(['message' => 'User created'], 201);
    }
}

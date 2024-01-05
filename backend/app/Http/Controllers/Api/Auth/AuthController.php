<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function auth(Request $request)
    {
        /**
         * @var User $user
         */
        $user = User::where('email', $request->email)->first();

        if (!$user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['E-mail ou senha invalidos']
            ]);
        }

        $user->tokens()->delete();
        $abilities = $request->input('abilities') ?: ['*'];

        $token = $user->createToken('login', \Arr::wrap($abilities))->plainTextToken;

        return response()->json([
            'token' => $token,
        ]);
    }
}

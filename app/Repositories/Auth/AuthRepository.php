<?php

namespace App\Repositories\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthRepository implements AuthRepositoryInterface {
    private $user;
    public function __construct(User $user) {
        $this->user = $user;
    }

    public function login(Request $request) {
        $user = $this->user->where('username', $request->input('username'))
            ->first();
        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return null;
        }

        $token = JWTAuth::fromUser($user);
        return [
            'access_token' => $token,
        ];
    }
    public function register(Request $request) {
        $avatar = $request->file('avatar') ? $request->file('avatar')->store('public/avatars') : null;
        $this->user->create([
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'avatar' => $avatar,
            'name' => $request->name,
        ]);
    }
}

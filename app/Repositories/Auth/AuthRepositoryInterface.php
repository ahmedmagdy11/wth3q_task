<?php

namespace App\Repositories\Auth;

use Illuminate\Http\Request;

interface AuthRepositoryInterface {
    public function login(Request $request);
    public function register(Request $request);
}

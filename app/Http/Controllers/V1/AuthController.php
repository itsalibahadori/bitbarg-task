<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\LoginFormRequest;
use App\Http\Requests\V1\Auth\RegisterFormRequest;
use App\Services\V1\Auth\AuthService;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ){}


    public function login(LoginFormRequest $request)
    {
        return $this->authService->login($request->all());
    }

    public function register(RegisterFormRequest $request) 
    {
        return $this->authService->register($request->all());
    }
}

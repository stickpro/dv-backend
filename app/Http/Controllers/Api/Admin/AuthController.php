<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\User\TokenResource;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $auth)
    {
    }

    public function login(LoginRequest $request): TokenResource
    {
        $input = $request->validated();

        return new TokenResource(
            $this->auth->loginAdmin($input['email'], $input['password'])
        );
    }
}
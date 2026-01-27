<?php

namespace App\Services\V1\Auth;

use App\Repositories\V1\User\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    public function register(array $data): User
    {
        $hashedPassword = Hash::make(Arr::get($data, 'password'));

        $data = Arr::set($data, 'password', $hashedPassword);

        return $this->userRepository->create($data);
    }

    public function login(array $data): ?string
    {
        $user = $this->userRepository->findByEmail(Arr::get($data, 'email'));

        if (!$user || !Hash::check(Arr::get($data, 'password'), $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['The provided password is incorrect.']
            ]);
        }

        return $user->createToken('rest-login')->plainTextToken;
    }
}

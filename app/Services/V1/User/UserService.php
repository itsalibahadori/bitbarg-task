<?php

namespace App\Services\V1\User;

use App\Models\User;
use App\Repositories\V1\User\UserRepository;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    public function getUsers(array $data)
    {
        return $this->userRepository->getUsers($data);
    }

    public function create(array $data): User
    {
        return $this->userRepository->create($data);
    }

    public function update(User $user, array $data): User
    {
        return $this->userRepository->update($user, $data);
    }

    public function destroy(User $user): void
    {
        $this->userRepository->destroy($user);
    }
}

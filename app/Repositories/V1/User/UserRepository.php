<?php

namespace App\Repositories\V1\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
   public function getUsers(array $filters): Collection
    {
        $cacheKey = 'users:' . md5(json_encode(Arr::sortRecursive($filters)));

        return Cache::tags(['users'])
            ->remember($cacheKey, now()->addMinutes(1), function () use ($filters) {
                return User::query()
                    ->when(
                        Arr::get($filters, 'email'),
                        fn ($q) => $q->where('email', Arr::get($filters, 'email'))
                    )
                    ->when(
                        Arr::get($filters, 'name'),
                        fn ($q) => $q->where('name', 'LIKE', '%' . Arr::get($filters, 'name') . '%')
                    )
                    ->get();
            });
    }

    public function create(array $data): User
    {
        $data = Arr::set($data, 'password', $this->hashPassword($data));

        return User::create($data);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function update(User $user, array $data): User
    {
        if (Arr::get($data, 'password')) {
            Arr::set($data, 'password', $this->hashPassword($data));
        }

        $user->update($data);

        return $user->fresh();
    }

    public function destroy(User $user): void
    {
        $user->delete();
    }

    private function hashPassword(array $data): string
    {
        return Hash::make(Arr::get($data, 'password'));
    }
}

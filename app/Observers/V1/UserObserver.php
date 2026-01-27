<?php

namespace App\Observers\V1;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        Log::channel('operation')->info('user created.', [
            'created_by' => auth()?->id(),
        ]);

        $user->assignRole('user');
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        Log::channel('operation')->info('user updated.', [
            'updated_by' => auth()->id(),
            'updated_user' => $user->id,
            'original' => $user->getOriginal(),
            'changes' => $user->getChanges(),
        ]);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        Log::channel('operation')->info('user deleted.', [
            'deleted_by' => auth()->id(),
        ]);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}

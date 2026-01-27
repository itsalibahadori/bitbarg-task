<?php

namespace App\Observers\V1;

use App\Models\Task;
use Illuminate\Support\Facades\Log;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        Log::channel('operation')->info('Task created.', [
            'user_id' => auth()->id(),
            'task_id' => $task->id,
        ]);
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        $changes = $task->getChanges();

        $original = $task->getOriginal();

        Log::channel('operation')->info('Task update.', [
            'update_by_user' => auth()->id(),
            'task_id' => $task->id,
            'changes' => $changes,
            'original' => $original,
        ]);
        
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        Log::channel('operation')->info('Task deleted..', [
            'deleted_by_user' => auth()->id(),
            'task_id' => $task->id,
        ]);
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}

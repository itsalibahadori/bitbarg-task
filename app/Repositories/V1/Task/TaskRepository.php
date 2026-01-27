<?php

namespace App\Repositories\V1\Task;

use App\Enums\V1\TaskEnums;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class TaskRepository
{
    public function searchAndFilter(array $filters)
    {
        $cacheKey = 'tasks:' . md5(json_encode(Arr::sortRecursive($filters)));

        return Cache::tags(['tasks'])
            ->remember($cacheKey, now()->addMinutes(), function () use ($filters) {
                return Task::query()
                    ->when(
                        Arr::get($filters, 'assigned_user_id'),
                        fn ($q, $userId) =>
                            $q->whereHas('assignedUsers', fn ($sub) =>
                                $sub->where('users.id', $userId)
                            )
                    )
                    ->when(
                        Arr::get($filters, 'creator'),
                        fn ($q) => $q->where('user_id', Arr::get($filters, 'creator'))
                    )
                    ->when(
                        Arr::get($filters, 'status'),
                        fn ($q) => $q->where('status', Arr::get($filters, 'status'))
                    )
                    ->when(
                        Arr::get($filters, 'title'),
                        fn ($q) => $q->where('title', 'LIKE', '%' . Arr::get($filters, 'title') . '%')
                    )
                    ->when(
                        Arr::get($filters, 'description'),
                        fn ($q) => $q->where('description', 'LIKE', '%' . Arr::get($filters, 'description') . '%')
                    )
                    ->when(
                        Arr::get($filters, 'due_date'),
                        fn ($q) => $q->whereDate('due_date', Arr::get($filters, 'due_date'))
                    )
                    ->get();
            });
    }
    
    public function create(array $data): Task
    {
        $data = array_merge([
            'status' => TaskEnums::PENDING,
            'user_id' => auth()->id(),
        ], $data);

        $task = Task::query()->create($data);

        if ($assignedUsers = Arr::get($data, 'assigned_users')) {
            $task->assignedUsers()->sync($assignedUsers);
        }

        return $task;
    }

    public function update(array $data, Task $task): Task
    {
        $assignedUsers = Arr::get($data, 'assigned_users');

        $task->update(Arr::except($data, 'assigned_users'));

        if ($assignedUsers) {
            $task->assignedUsers()->sync($assignedUsers);
        }

        return $task->fresh();
    }

    public function destroy(Task $task)
    {
        $task->delete();
    }

    public function allTasks(): Collection
    {
        return Task::all();
    }

    public function updateTaskStatus(Task $task, string $status): Task
    {
        $task->update([
            'status' => $status
        ]);

        return $task->fresh();
    }
}

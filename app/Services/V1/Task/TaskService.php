<?php

namespace App\Services\V1\Task;

use App\Models\Task;
use App\Repositories\V1\Task\TaskRepository;

class TaskService
{
    public function __construct(
        protected TaskRepository $taskRepository
    ) {}

    public function getTasks(array $data)
    {
        return $this->taskRepository->searchAndFilter($data);
    }

    public function create(array $data): Task
    {
        return $this->taskRepository->create($data);
    }

    public function update(array $data, Task $task): Task
    {
        return $this->taskRepository->update($data, $task);
    }

    public function destroy(Task $task): void
    {
        $this->taskRepository->destroy($task);
    }

    public function updateTaskStatus(Task $task, string $status): Task
    {
        return $this->taskRepository->updateTaskStatus($task, $status);
    }
}

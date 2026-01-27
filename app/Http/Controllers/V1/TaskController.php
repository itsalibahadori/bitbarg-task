<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Task\StoreTaskFormRequest;
use App\Http\Requests\V1\Task\UpdateTaskFormRequest;
use App\Http\Requests\V1\Task\UpdateTaskStatusFormRequest;
use App\Http\Resources\V1\TaskResource;
use App\Models\Task;
use App\Services\V1\Task\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $taskService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only([
            'title',
            'description',
            'creator',
            'assigned_user_id',
            'due_date',
            'status',
        ]);

        $tasks = $this->taskService->getTasks($filters);

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskFormRequest $request)
    {
        $task = $this->taskService->create($request->all());

        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskFormRequest $request, Task $task)
    {
        $task = $this->taskService->update($request->all(), $task);

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->taskService->destroy($task);

        return response()->json([
            'message' => 'Task Deleted.'
        ]);
    }

    public function updateTaskStatus(UpdateTaskStatusFormRequest $request, Task $task)
    {
        $task = $this->taskService->updateTaskStatus($task, $request->get('status'));

        return new TaskResource($task);
    }
}

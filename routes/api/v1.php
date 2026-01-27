<?php

use App\Http\Controllers\V1\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\TaskController;
use App\Http\Controllers\V1\UsersController;

Route::group([
    'prefix' => 'v1',
    'middleware' => [
        'throttle:60,1',
    ]
], function () {

    Route::group([
        'prefix' => 'auth'
    ], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
    });


    Route::middleware('auth:sanctum')
        ->group(function () {
            Route::patch('tasks/{task}/update-status', [TaskController::class, 'updateTaskStatus']);
                Route::get('tasks', [TaskController::class, 'index'])->middleware('permissions:task.view');
            Route::post('tasks', [TaskController::class, 'store'])->middleware('permissions:task.create');
            Route::put('tasks/{task}', [TaskController::class, 'update'])
                ->middleware(['permissions:task.update', 'taskOwner']);
            Route::patch('tasks/{task}', [TaskController::class, 'update'])
                ->middleware(['permissions:task.update', 'taskOwner']);

            Route::delete('tasks/{task}', [TaskController::class, 'destroy'])
                ->middleware(['permissions:task.delete', 'taskOwner']);

            Route::apiResource('users', UsersController::class)->middleware('role:admin');
        });
});


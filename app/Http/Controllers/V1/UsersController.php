<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\User\StoreUserFormRequest;
use App\Http\Requests\V1\User\UpdateUserFormRequest;
use App\Http\Resources\V1\UsersResource;
use App\Models\User;
use App\Services\V1\User\UserService;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct
    (
        protected UserService $userService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['name', 'email']);

        $users = $this->userService->getUsers($filters);

        return UsersResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserFormRequest $request)
    {
        $user = $this->userService->create($request->all());

        return new UsersResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserFormRequest $request, User $user)
    {
        $user = $this->userService->update($user, $request->all());

        return new UsersResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->userService->destroy($user);

        response()->json([
            'message' => 'User deleted.'
        ]);
    }
}

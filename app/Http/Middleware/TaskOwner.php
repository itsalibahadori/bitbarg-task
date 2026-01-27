<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class TaskOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $task = $request->route('task');

        $user = $request->user();

        if ($user->hasRole('admin')) {
            return $next($request);
        }

        if ($task && $task->user_id !== $user->id) {
            throw new UnauthorizedException(
                statusCode: 403,
                message: "Unauthorized."
            );
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPostLimiting
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user->plan == ' free'){
            $userActionCount = $user->userActions()->where('post.status' , 'paid')->count();

            if ($userActionCount > 5){
                return redirect()->withErrors('your free trail has been ended you need to have subscription plan to access this post');
            }
        }

        return $next($request);
    }
}

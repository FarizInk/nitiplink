<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BotMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse|JsonResponse
    {
        $key = env('BOT_KEY', 'default');

        if ($key == $request->header('Bot-Key')) {
            return $next($request);
        } else {
            abort(403, 'Access Denied!');
        }
    }
}

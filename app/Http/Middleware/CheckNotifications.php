<?php

namespace App\Http\Middleware;

use App\Http\Controllers\NotificationController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckNotifications
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $notificationController = new NotificationController();
        $notifications = $notificationController->getNotifications();

        view()->share('notifications', $notifications['notifications']);
        view()->share('unreadCount', $notifications['unreadCount']);
        return $next($request);
    }
}

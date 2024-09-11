<?php

namespace App\Http\Controllers;

use App\Models\DetailObat;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $notificationsFile = storage_path('app/public/notifications.json');
        if (file_exists($notificationsFile)) {
            $notifications = json_decode(file_get_contents($notificationsFile), true);
            $unreadCount = count($notifications['lowStock']) + count($notifications['expiredSoon']);
        } else {
            $notifications = ['lowStock' => [], 'expiredSoon' => []];
            $unreadCount = 0;
        }

        return [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ];
    }
}

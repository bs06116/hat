<?php
namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    public function create($userId, $message)
    {
        return Notification::create([
            'user_id' => $userId,
            'message' => $message,
            'is_read' => false,
        ]);
    }
}

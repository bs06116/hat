<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = UserNotification::where('user_id', Auth::id())->get();
        return view('site.notifications.index', compact('notifications'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'status' => 'required|string|in:active,inactive',
        ]);
        // Assuming you have a NotificationSettings model to store the settings
        $notification = UserNotification::where('notification_type', $validated['type'])
                        ->where('user_id', Auth::id())->first();
        if ($notification) {
            $notification->status = $validated['status'];
        }else{
            $notification = new UserNotification();
            $notification->user_id = Auth::id();
            $notification->notification_type = $validated['type'];
            $notification->status = $validated['status'];
        }
        $notification->save();

        return response()->json(['success' => true, 'message' => 'Notification updated successfully.']);
    }

}


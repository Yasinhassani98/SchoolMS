<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\GeneralNotification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(10);

        return view('notifications.index', compact('notifications'));
    }
    public function create()
    {
        $users = User::all();
        return view('admin.notifications.create', compact('users'));
    }
    public function destroy($notificationId)
    {
        $notification = Auth::user()->notifications()->findOrFail($notificationId);
        $notification->delete();
        return back()->with('success', 'Notification deleted successfully.');
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        
        return back();
    }

    public function markAsUnread(Request $request, $id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsUnread();

        return back();
    }
    
    public function markAllAsRead(Request $request)
    {
        Auth::user()->unreadNotifications->markAsRead();
        
        return back();
    }
    
    /**
     * إرسال إشعار لمستخدم محدد
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendNotification(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,success,warning,danger',
        ]);
        
        $user = User::findOrFail($request->user_id);
        $user->notify(new GeneralNotification(
            $request->title,
            $request->message,
            $request->data ?? [],
            $request->type
        ));
        
        return back()->with('success', 'Notification sent successfully.');
    }
    
    /**
     * إرسال إشعار لجميع المستخدمين
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function broadcastNotification(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,success,warning,danger',
        ]);
        
        $users = User::all();
        foreach ($users as $user) {
            $user->notify(new GeneralNotification(
                $request->title,
                $request->message,
                $request->data ?? [],
                $request->type
            ));
        }
        
        return back()->with('success', 'Notification sent successfully to all users.');
    }
    
    /**
     * إرسال إشعار لمجموعة محددة من المستخدمين
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendNotificationToGroup(Request $request)
    {
        $request->validate([
            'role' => 'required|string',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,success,warning,danger',
        ]);
        
        $users = User::role($request->role)->get();
        foreach ($users as $user) {
            $user->notify(new GeneralNotification(
                $request->title,
                $request->message,
                $request->data ?? [],
                $request->type
            ));
        }
        
        return back()->with('success', "Notification sent successfully to all users with role '{$request->role}'.");
    }
}
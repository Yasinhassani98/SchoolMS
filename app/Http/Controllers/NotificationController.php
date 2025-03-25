<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\GeneralNotification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->notifications();
        
        // Filter by read/unread status
        if ($request->has('filter') && in_array($request->filter, ['read', 'unread'])) {
            if ($request->filter === 'read') {
                $query = Auth::user()->readNotifications();
            } else {
                $query = Auth::user()->unreadNotifications();
            }
        }
        
        // Filter by notification type
        if ($request->has('type') && in_array($request->type, ['info', 'success', 'warning', 'danger'])) {
            $query = $query->where('data->type', $request->type);
        }
        
        $notifications = $query->paginate(10);
        
        // Get available notification types for the filter dropdown
        $notificationTypes = ['info', 'success', 'warning', 'danger'];
        
        return view('notifications.index', compact('notifications', 'notificationTypes'));
    }
    public function create()
    {
        $users = User::all();
        $roles = Role::all();
        return view('admin.notifications.create', compact('users', 'roles'));
    }
    public function destroy($notificationId)
    {
        $notification = Auth::user()->notifications()->findOrFail($notificationId);
        $notification->delete();
        return back()->with('success', 'Notification deleted successfully.');
    }

    public function markAsRead(Request $request, $notificationId)
    {
        $notification = Auth::user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();
        
        return back();
    }

    public function markAsUnread(Request $request, $notificationId)
    {
        $notification = Auth::user()->notifications()->findOrFail($notificationId);
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
            'title' => 'required|string',
            'message' => 'required|string',
            'type' =>'required|in:info,success,warning,danger'
        ]);

        $user = User::findOrFail($request->user_id);
        $notification = new GeneralNotification(
            $request->title,
            $request->message,
            $request->data ?? [],
            $request->type
        );
        
        $user->notify($notification);

        return redirect()->back()->with('success', 'Notification sent successfully.');
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
            'role' => 'required|exists:roles,name',
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
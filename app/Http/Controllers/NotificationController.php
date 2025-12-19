<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Obtener todas las notificaciones del usuario autenticado
    public function index()
    {
        $notifications = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json($notifications);
    }

    // Obtener el conteo de notificaciones no leídas
    public function unreadCount()
    {
        $count = Auth::user()->notifications()
            ->where('read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    // Marcar una notificación como leída
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->findOrFail($id);
        
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    // Marcar todas las notificaciones como leídas
    public function markAllAsRead()
    {
        Auth::user()->notifications()
            ->where('read', false)
            ->update(['read' => true]);

        return response()->json(['success' => true]);
    }
}

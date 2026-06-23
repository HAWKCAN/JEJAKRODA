<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(10);
        return view('notifications.index', compact('notifications'));
    }

    public function markAllRead()
    {
        // Pastikan user sedang login
        $user = auth()->user();
        
        if ($user) {
            // Mengubah status semua notifikasi yang belum dibaca menjadi terbaca
            $user->unreadNotifications->markAsRead();
        }

        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }
}
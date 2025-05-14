<?php
// API route for getting notifications for the notification dropdown
Route::get('/api/notifications', function () {
    $user = auth()->user();
    if (!$user) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    
    $notifications = $user->notifications()
                         ->limit(5)
                         ->get()
                         ->map(function ($notification) {
                             $data = $notification->data;
                             return [
                                 'id' => $notification->id,
                                 'type' => $data['type'] ?? 'system',
                                 'title' => $data['title'] ?? 'Pemberitahuan Sistem',
                                 'message' => $data['message'] ?? 'Tidak ada pesan tambahan.',
                                 'read' => !is_null($notification->read_at),
                                 'time' => $notification->created_at->diffForHumans(),
                                 'created_at' => $notification->created_at->toISOString()
                             ];
                         });
                         
    return response()->json([
        'notifications' => $notifications,
        'unread_count' => $user->unreadNotifications->count()
    ]);
});

// API route for getting unread notification count
Route::get('/api/notifications/unread-count', function () {
    $user = auth()->user();
    if (!$user) {
        return response()->json(['count' => 0]);
    }
    
    return response()->json([
        'count' => $user->unreadNotifications->count()
    ]);
});

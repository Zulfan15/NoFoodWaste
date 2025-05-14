<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NotificationController extends Controller
{    /**
     * Display user notifications
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Handle mark all as read if requested
        if ($request->has('mark_as_read') && $request->mark_as_read == 'true') {
            $user->unreadNotifications->markAsRead();
            return redirect()->route('notifications')->with('success', 'Semua notifikasi telah ditandai sebagai dibaca');
        }
        
        // Generate sample notifications if requested
        if ($request->has('generate_samples') && $request->generate_samples == 'true') {
            $this->createSampleNotifications($user);
            return redirect()->route('notifications')->with('success', 'Contoh notifikasi berhasil dibuat');
        }
        
        // Get notifications for display
        $notifications = $user->notifications()->paginate(10);
        $unreadCount = $user->unreadNotifications->count();
        
        return view('user.notifications', compact('notifications', 'unreadCount'));
    }
      /**
     * Mark a notification as read
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(Request $request)
    {
        $notificationId = $request->notification_id;
        $notification = Auth::user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();
        
        return response()->json([
            'success' => true,
            'message' => 'Notifikasi ditandai sebagai dibaca'
        ]);
    }
    
    /**
     * Create sample notifications for demonstration purposes
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    private function createSampleNotifications($user)
    {
        // Sample donation notification
        $donationData = [
            'type' => 'donation',
            'title' => 'Donasi baru tersedia',
            'message' => 'Restoran Sehat Selalu telah menambahkan donasi makanan baru.',
            'donation_id' => 1
        ];
        
        $user->notify(new \App\Notifications\GeneralNotification($donationData));
        
        // Sample claim notification
        $claimData = [
            'type' => 'claim',
            'title' => 'Klaim donasi dikonfirmasi',
            'message' => 'Donasi makanan dari Warung Barokah telah dikonfirmasi dan siap untuk diambil.',
            'donation_id' => 2,
            'claim_id' => 1
        ];
        
        $newNotification = $user->notify(new \App\Notifications\GeneralNotification($claimData));
        
        // Sample system notification (already read)
        $systemData = [
            'type' => 'system',
            'title' => 'Pembaruan profil berhasil',
            'message' => 'Profil anda telah berhasil diperbarui.'
        ];
        
        $notification = $user->notify(new \App\Notifications\GeneralNotification($systemData));
        
        // Mark system notification as read
        $user->notifications()->latest()->first()->markAsRead();
        
        // Sample for older notification (from yesterday)
        $oldData = [
            'type' => 'donation',
            'title' => 'Donasi anda telah berhasil ditambahkan',
            'message' => 'Terima kasih telah berkontribusi dalam mengurangi pemborosan makanan.'
        ];
        
        $oldNotification = $user->notify(new \App\Notifications\GeneralNotification($oldData));
        
        // Set created_at to yesterday
        $yesterday = Carbon::now()->subDay();
        $user->notifications()->latest()->first()->update(['created_at' => $yesterday]);
        
        // Mark as read
        $user->notifications()->latest()->first()->markAsRead();
    }
}

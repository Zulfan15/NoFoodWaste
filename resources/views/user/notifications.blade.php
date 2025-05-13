@extends('layouts.admin.master')

@section('title', 'Notifikasi Saya')

@section('css')
<style>
    .notification-container {
        background-color: #fff;
        border-radius: 20px;
        box-shadow: 0 5px 20px rgba(36, 105, 92, 0.08);
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .notification-header {
        background: linear-gradient(135deg, #24695c, #3a9188);
        color: #fff;
        padding: 20px 30px;
        position: relative;
    }
    
    .notification-body {
        padding: 20px;
    }
    
    .notification-item {
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 10px;
        border-left: 4px solid transparent;
        transition: all 0.2s;
        position: relative;
    }
    
    .notification-item:hover {
        background-color: #f8f9fa;
    }
    
    .notification-item.unread {
        background-color: #f0f8ff;
        border-left-color: #3a9188;
    }
    
    .notification-item .notification-time {
        color: #7a7a7a;
        font-size: 0.75rem;
    }
    
    .notification-item .notification-title {
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .notification-item .notification-content {
        color: #333;
    }
    
    .notification-actions {
        margin-bottom: 20px;
    }
    
    .notification-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-right: 15px;
    }
    
    .icon-donation {
        background-color: rgba(58, 145, 136, 0.1);
        color: #3a9188;
    }
    
    .icon-claim {
        background-color: rgba(255, 152, 0, 0.1);
        color: #ff9800;
    }
    
    .icon-system {
        background-color: rgba(76, 78, 100, 0.1);
        color: #4c4e64;
    }
    
    .empty-notification {
        text-align: center;
        padding: 40px 20px;
    }
    
    .empty-notification i {
        font-size: 2.5rem;
        color: #d1d1d1;
        margin-bottom: 15px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3>Notifikasi Saya</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                    <li class="breadcrumb-item active">Notifikasi</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="notification-container">
                <div class="notification-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Semua Notifikasi</h5>
                        <p class="mb-0 text-white-50">{{ $notifications->total() }} notifikasi total</p>
                    </div>
                    <div>
                        @if($unreadCount > 0)
                            <span class="badge badge-light">{{ $unreadCount }} belum dibaca</span>
                        @endif
                    </div>
                </div>
                
                <div class="notification-body">
                    @if($unreadCount > 0)
                        <div class="notification-actions">
                            <a href="{{ route('notifications', ['mark_as_read' => 'true']) }}" class="btn btn-outline-primary">
                                <i data-feather="check-circle" class="icon-xs"></i> Tandai semua sebagai dibaca
                            </a>
                        </div>
                    @endif
                    
                    @if($notifications->count() > 0)
                        <div class="notification-list">
                            @foreach($notifications as $notification)
                                @php
                                    $isUnread = is_null($notification->read_at);
                                    $data = $notification->data;
                                    $notificationType = $data['type'] ?? 'system';
                                    $title = $data['title'] ?? 'Pemberitahuan Sistem';
                                    $message = $data['message'] ?? 'Tidak ada pesan tambahan.';
                                    $time = $notification->created_at->diffForHumans();
                                    $iconClass = 'icon-system';
                                    $icon = 'bell';
                                    
                                    if($notificationType == 'donation') {
                                        $iconClass = 'icon-donation';
                                        $icon = 'package';
                                    } elseif($notificationType == 'claim') {
                                        $iconClass = 'icon-claim';
                                        $icon = 'shopping-bag';
                                    }
                                @endphp
                                
                                <div class="notification-item d-flex {{ $isUnread ? 'unread' : '' }}">
                                    <div class="notification-icon {{ $iconClass }}">
                                        <i data-feather="{{ $icon }}"></i>
                                    </div>
                                    <div class="notification-content-wrapper">
                                        <div class="d-flex justify-content-between">
                                            <div class="notification-title">{{ $title }}</div>
                                            <div class="notification-time">{{ $time }}</div>
                                        </div>
                                        <div class="notification-content">{{ $message }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="empty-notification">
                            <i data-feather="bell-off"></i>
                            <h6>Tidak Ada Notifikasi</h6>
                            <p class="text-muted">Saat ini Anda tidak memiliki notifikasi</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Initialize feather icons
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });
</script>
@endsection

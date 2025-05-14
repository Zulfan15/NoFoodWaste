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
    
    /* Responsive adjustments */
    @media (max-width: 767px) {
        .notification-page-header {
            padding: 15px 20px;
            flex-direction: column;
            align-items: flex-start !important;
        }
        
        .notification-page-header div:last-child {
            margin-top: 10px;
        }
        
        .notification-page-controls {
            flex-direction: column;
        }
        
        .notification-page-controls > div:first-child {
            margin-bottom: 10px;
        }
        
        .notification-body {
            padding: 15px;
        }
        
        .notification-page-item {
            padding: 12px;
        }
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
            <div class="notification-container">                <div class="notification-page-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold">Semua Notifikasi</h5>
                        <p class="mb-0 text-white-50 mt-1">{{ $notifications->total() }} notifikasi total</p>
                    </div>
                    <div>
                        @if($unreadCount > 0)
                            <span class="badge bg-light text-dark px-3 py-2 rounded-pill fw-normal">
                                {{ $unreadCount }} belum dibaca
                            </span>
                        @endif
                        
                        @if($notifications->count() === 0)
                            <!-- Demo button for generating sample notifications -->
                            <a href="{{ route('notifications', ['generate_samples' => 'true']) }}" class="btn btn-sm btn-light ms-2">
                                <i data-feather="plus-circle" class="icon-sm me-1"></i> Buat Contoh Notifikasi
                            </a>
                        @endif
                    </div>
                </div>
                
                <div class="notification-body">
                    <div class="notification-page-controls">
                        <div class="d-flex flex-wrap gap-2 mb-2 mb-md-0">
                            @if($unreadCount > 0)
                                <a href="{{ route('notifications', ['mark_as_read' => 'true']) }}" class="btn btn-primary">
                                    <i data-feather="check-circle" class="icon-sm me-1"></i> Tandai semua sebagai dibaca
                                </a>
                            @endif
                        </div>
                        <div>
                            <select class="form-select form-select-sm" id="notificationFilter">
                                <option value="all">Semua notifikasi</option>
                                <option value="unread">Belum dibaca</option>
                                <option value="read">Sudah dibaca</option>
                            </select>
                        </div>
                    </div>
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
                                
                                <div class="notification-page-item {{ $isUnread ? 'unread' : '' }}" 
                                     data-status="{{ $isUnread ? 'unread' : 'read' }}">
                                    <div class="notification-icon {{ $iconClass }}">
                                        <i data-feather="{{ $icon }}"></i>
                                    </div>
                                    <div class="notification-content-wrapper w-100">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="notification-title mb-0">{{ $title }}</h6>
                                            <small class="notification-time text-muted">{{ $time }}</small>
                                        </div>
                                        <p class="notification-message mb-0">{{ $message }}</p>
                                        @if($isUnread)
                                            <div class="mt-2 text-end">
                                                <a href="#" class="text-primary mark-read-link" data-id="{{ $notification->id }}">
                                                    <small>Tandai dibaca</small>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="empty-notification text-center py-5">
                            <i data-feather="bell-off" style="width: 48px; height: 48px; color: #ccc; margin-bottom: 15px;"></i>
                            <h5>Tidak Ada Notifikasi</h5>
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

        // Show success message if exists in session
        @if(session('success'))
            showToast("{{ session('success') }}", 'success');
        @endif

        // Notification filtering
        $('#notificationFilter').on('change', function() {
            const filterValue = $(this).val();
            
            if (filterValue === 'all') {
                $('.notification-page-item').show();
            } else {
                $('.notification-page-item').hide();
                $(`.notification-page-item[data-status="${filterValue}"]`).show();
            }
            
            // Show empty state if no results
            const visibleItems = $('.notification-page-item:visible').length;
            if (visibleItems === 0) {
                if ($('.no-results-message').length === 0) {
                    $('.notification-list').append(`
                        <div class="no-results-message text-center py-4">
                            <i data-feather="search" style="width: 40px; height: 40px; color: #ccc; margin-bottom: 15px;"></i>
                            <h6>Tidak Ada Hasil</h6>
                            <p class="text-muted">Tidak ditemukan notifikasi dengan filter yang dipilih</p>
                        </div>
                    `);
                    feather.replace();
                } else {
                    $('.no-results-message').show();
                }
            } else {
                $('.no-results-message').hide();
            }
        });

        // Mark individual notification as read
        $(document).on('click', '.mark-read-link', function(e) {
            e.preventDefault();
            const notificationId = $(this).data('id');
            const notificationItem = $(this).closest('.notification-page-item');
            
            // AJAX request would go here in a real app
            // For this demo, we'll just simulate success
            notificationItem.removeClass('unread');
            notificationItem.attr('data-status', 'read');
            $(this).parent().fadeOut();
            
            // Update unread counter
            let unreadCount = parseInt($('.badge-pill').text());
            if (unreadCount > 0) {
                unreadCount--;
                $('.badge-pill').text(unreadCount);
                
                if (unreadCount === 0) {
                    $('.badge-pill').hide();
                }
            }
            
            // Show success toast
            showToast('Notifikasi ditandai sebagai dibaca', 'success');
        });
        
        // Simple toast notification function
        function showToast(message, type = 'info') {
            // Create toast container if it doesn't exist
            if ($('#toast-container').length === 0) {
                $('body').append('<div id="toast-container" class="position-fixed top-0 end-0 p-3" style="z-index: 1050;"></div>');
            }
            
            // Generate unique ID for this toast
            const id = 'toast-' + Date.now();
            
            // Create toast HTML
            const toast = `
                <div id="${id}" class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;
            
            // Add toast to container
            $('#toast-container').append(toast);
            
            // Initialize and show the toast
            const toastElement = document.getElementById(id);
            const bsToast = new bootstrap.Toast(toastElement, {
                autohide: true,
                delay: 3000
            });
            bsToast.show();
            
            // Remove toast from DOM after it's hidden
            $(toastElement).on('hidden.bs.toast', function() {
                $(this).remove();
            });
        }
    });
</script>
@endsection

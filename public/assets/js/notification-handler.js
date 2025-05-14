/**
 * Notification Dropdown Handler
 * 
 * This script manages the notification dropdown in the header,
 * handling loading, rendering, and interactions with notifications.
 */

document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const notificationBtn = document.querySelector('.notification-box');
    const notificationDropdown = document.querySelector('.notification-dropdown');
    const notificationContent = document.querySelector('.notification-content');
    const notificationCounter = document.querySelector('.notification-counter');
    const notificationBadge = document.querySelector('.notification-badge');
    const loadingEl = document.querySelector('.notification-loading');
    const emptyStateEl = document.querySelector('.empty-state');
    const errorStateEl = document.querySelector('.error-state');
    const retryBtn = document.querySelector('.retry-load');
    const markAllReadBtn = document.querySelector('.notification-actions a:first-child');
    
    // Variables
    let isLoading = false;
    let isLoaded = false;
    let notificationsData = [];
    let unreadCount = 0;
    
    // Init
    initNotifications();
    
    // Event listeners
    if (notificationBtn) {
        notificationBtn.addEventListener('click', handleNotificationClick);
    }
    
    if (retryBtn) {
        retryBtn.addEventListener('click', loadNotifications);
    }
    
    if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', function(e) {
            // Don't prevent default since it's a link to a route
            markAllNotificationsAsRead();
        });
    }
    
    /**
     * Initialize notifications
     */
    function initNotifications() {
        // Check if user has unread notifications and update counter
        checkUnreadNotifications();
        
        // Add document click event to close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (notificationDropdown && 
                !notificationDropdown.contains(e.target) && 
                !notificationBtn.contains(e.target)) {
                closeNotificationDropdown();
            }
        });
    }
    
    /**
     * Handle notification button click
     */
    function handleNotificationClick(e) {
        e.preventDefault();
        e.stopPropagation();
        
        if (notificationDropdown.classList.contains('show')) {
            closeNotificationDropdown();
        } else {
            openNotificationDropdown();
            
            // Load notifications if not loaded
            if (!isLoaded && !isLoading) {
                loadNotifications();
            }
        }
    }
    
    /**
     * Open notification dropdown
     */
    function openNotificationDropdown() {
        notificationDropdown.classList.add('show');
        notificationBtn.setAttribute('aria-expanded', 'true');
    }
    
    /**
     * Close notification dropdown
     */
    function closeNotificationDropdown() {
        notificationDropdown.classList.remove('show');
        notificationBtn.setAttribute('aria-expanded', 'false');
    }
    
    /**
     * Check if user has unread notifications
     */
    function checkUnreadNotifications() {
        // For demo, we'll use sample data
        updateNotificationCounter(3);
        
        // In a real app, you would call your API to get the unread count
        /*
        fetch('/api/notifications/unread-count')
            .then(response => response.json())
            .then(data => {
                updateNotificationCounter(data.count);
            })
            .catch(error => {
                console.error('Error fetching notification count:', error);
            });
        */
    }
    
    /**
     * Update notification counter in UI
     */
    function updateNotificationCounter(count) {
        unreadCount = count;
        
        if (notificationCounter) {
            if (count > 0) {
                notificationCounter.textContent = count;
                notificationCounter.style.display = 'flex';
            } else {
                notificationCounter.style.display = 'none';
            }
        }
        
        if (notificationBadge) {
            notificationBadge.textContent = count;
        }
    }
    
    /**
 * Load notifications
 */
function loadNotifications() {
    // Show loading
    showLoading();
    
    // In a real app, fetch from API
    // For demo, we'll use sample data
    setTimeout(() => {
        // Sample notification data
        isLoaded = true;
        isLoading = false;
        notificationsData = [
            {
                id: 'notif-1',
                type: 'donation',
                title: 'Donasi baru tersedia',
                message: 'Restoran Sehat Selalu telah menambahkan donasi makanan baru.',
                read: false,
                time: 'Baru saja'
            },
            {
                id: 'notif-2',
                type: 'claim',
                title: 'Klaim donasi dikonfirmasi',
                message: 'Donasi makanan dari Warung Barokah telah dikonfirmasi dan siap untuk diambil.',
                read: false,
                time: '2 jam yang lalu'
            },
            {
                id: 'notif-3',
                type: 'system',
                title: 'Pembaruan profil berhasil',
                message: 'Profil anda telah berhasil diperbarui.',
                read: true,
                time: '1 hari yang lalu'
            }
        ];
        
        // Update unread count
        updateNotificationCounter(notificationsData.filter(n => !n.read).length);
        
        // Render notifications
        renderNotifications();
        
        // Update last updated time
        updateLastUpdatedTime();
    }, 500);
}
    
    /**
     * Show loading state
     */
    function showLoading() {
        isLoading = true;
        
        if (loadingEl) loadingEl.style.display = 'block';
        if (emptyStateEl) emptyStateEl.style.display = 'none';
        if (errorStateEl) errorStateEl.style.display = 'none';
    }
    
    /**
     * Hide loading state
     */
    function hideLoading() {
        isLoading = false;
        
        if (loadingEl) loadingEl.style.display = 'none';
    }
    
    /**
     * Render notifications in dropdown
     */
    function renderNotifications() {
        // Hide loading
        hideLoading();
        
        // Clear existing content except static elements
        notificationContent.querySelectorAll('.notification-item').forEach(item => {
            item.remove();
        });
        
        // Show appropriate state
        if (notificationsData.length === 0) {
            if (emptyStateEl) emptyStateEl.style.display = 'block';
            if (errorStateEl) errorStateEl.style.display = 'none';
        } else {
            if (emptyStateEl) emptyStateEl.style.display = 'none';
            if (errorStateEl) errorStateEl.style.display = 'none';
            
            // Render notifications
            notificationsData.forEach(notification => {
                // Create notification item
                const iconClass = notification.type === 'donation' ? 'icon-donation' : 
                                (notification.type === 'claim' ? 'icon-claim' : 'icon-system');
                const icon = notification.type === 'donation' ? 'package' : 
                           (notification.type === 'claim' ? 'shopping-bag' : 'bell');
                
                const notificationItem = document.createElement('div');
                notificationItem.className = `notification-item ${notification.read ? '' : 'unread'}`;
                notificationItem.dataset.id = notification.id;
                notificationItem.innerHTML = `
                    <div class="notification-icon ${iconClass}">
                        <i data-feather="${icon}"></i>
                    </div>
                    <div class="notification-content-wrapper">
                        <div class="notification-title">${notification.title}</div>
                        <p class="notification-message">${notification.message}</p>
                        <small class="notification-time">${notification.time}</small>
                        ${!notification.read ? `
                        <div class="notification-actions">
                            <a href="#" class="mark-read" data-id="${notification.id}">Tandai dibaca</a>
                        </div>
                        ` : ''}
                    </div>
                `;
                
                // Add before empty state
                if (emptyStateEl) {
                    notificationContent.insertBefore(notificationItem, emptyStateEl);
                } else {
                    notificationContent.appendChild(notificationItem);
                }
            });
            
            // Re-initialize feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
            
            // Add event listeners to mark as read buttons
            document.querySelectorAll('.notification-item .mark-read').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.dataset.id;
                    const notificationItem = this.closest('.notification-item');
                    
                    // Update data
                    const notification = notificationsData.find(n => n.id === id);
                    if (notification) {
                        notification.read = true;
                    }
                    
                    // Update UI
                    notificationItem.classList.remove('unread');
                    this.parentElement.remove();
                    
                    // Update counter
                    updateNotificationCounter(notificationsData.filter(n => !n.read).length);
                });
            });
        }
    }
    
    /**
     * Update last updated time
     */
    function updateLastUpdatedTime() {
        const lastUpdatedEl = document.querySelector('.last-updated');
        if (lastUpdatedEl) {
            lastUpdatedEl.textContent = 'Baru saja';
        }
    }
      /**
     * Mark all notifications as read
     */
    function markAllNotificationsAsRead() {
        // In a real app, send request to mark all as read
        // Here we'll just update the UI
        updateNotificationCounter(0);
        
        // Update notification items in UI
        document.querySelectorAll('.notification-item.unread').forEach(item => {
            item.classList.remove('unread');
            const actionEl = item.querySelector('.notification-actions');
            if (actionEl) {
                actionEl.remove();
            }
        });
        
        // Show success toast
        if (typeof showToast === 'function') {
            showToast('Semua notifikasi ditandai sebagai dibaca', 'success');
        }
    }
    
    /**
     * Handle mobile-specific behavior
     */
    function handleMobileNotifications() {
        // Close dropdown when clicked outside on mobile
        if (window.innerWidth < 768) {
            document.addEventListener('touchstart', function(e) {
                if (notificationDropdown && 
                    !notificationDropdown.contains(e.target) && 
                    !notificationBtn.contains(e.target)) {
                    closeNotificationDropdown();
                }
            });
            
            // Add swipe-to-dismiss functionality for notification items
            const notificationItems = document.querySelectorAll('.notification-item');
            notificationItems.forEach(item => {
                let touchStartX = 0;
                let touchEndX = 0;
                
                item.addEventListener('touchstart', function(e) {
                    touchStartX = e.changedTouches[0].screenX;
                }, false);
                
                item.addEventListener('touchend', function(e) {
                    touchEndX = e.changedTouches[0].screenX;
                    handleSwipe(item, touchStartX, touchEndX);
                }, false);
            });
        }
    }
    
    /**
     * Handle swipe gesture on notification items
     */
    function handleSwipe(element, startX, endX) {
        const threshold = 100; // Minimum distance to recognize as swipe
        
        if (startX - endX > threshold) {
            // Swiped left - mark as read
            const id = element.dataset.id;
            element.classList.remove('unread');
            const actionEl = element.querySelector('.notification-actions');
            if (actionEl) {
                actionEl.remove();
            }
            
            // Update notification in data
            const notification = notificationsData.find(n => n.id === id);
            if (notification) {
                notification.read = true;
            }
            
            // Update counter
            updateNotificationCounter(notificationsData.filter(n => !n.read).length);
        }
    }
    
    // Add simple toast notification function for mobile
    function showToast(message, type = 'info') {
        // Create toast container if it doesn't exist
        if (!document.getElementById('toast-container')) {
            const toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.className = 'position-fixed top-0 end-0 p-3';
            toastContainer.style.zIndex = 1050;
            document.body.appendChild(toastContainer);
        }
        
        // Generate unique ID for this toast
        const id = 'toast-' + Date.now();
        
        // Create toast element
        const toast = document.createElement('div');
        toast.id = id;
        toast.className = `toast align-items-center text-white bg-${type} border-0`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;
        
        // Add to container
        document.getElementById('toast-container').appendChild(toast);
        
        // Initialize and show with Bootstrap
        if (typeof bootstrap !== 'undefined') {
            const bsToast = new bootstrap.Toast(toast, {
                autohide: true,
                delay: 3000
            });
            bsToast.show();
        } else {
            // Fallback if Bootstrap isn't available
            toast.style.display = 'block';
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
        
        // Remove from DOM after hidden
        toast.addEventListener('hidden.bs.toast', function() {
            this.remove();
        });
    }
      // Initialize mobile handling
    handleMobileNotifications();
});

/**
 * NoFoodWaste Realtime Notification System
 * Handles real-time notifications via WebSockets
 * Created: May 20, 2025
 */

class RealtimeNotifications {
  /**
   * Initialize the real-time notification system
   * @param {Object} options - Configuration options
   * @param {String} options.url - WebSocket server URL
   * @param {Function} options.onConnect - Callback when connection is established
   * @param {Function} options.onDisconnect - Callback when connection is closed
   * @param {Function} options.onError - Callback when error occurs
   * @param {Function} options.onNotification - Callback when notification is received
   * @param {Function} options.onNotificationRead - Callback when notification is marked as read
   * @param {Function} options.onCountUpdate - Callback when notification count updates
   */
  constructor(options = {}) {
    this.url = options.url || this.getDefaultWebSocketUrl();
    this.onConnect = options.onConnect || (() => {});
    this.onDisconnect = options.onDisconnect || (() => {});
    this.onError = options.onError || (() => {});
    this.onNotification = options.onNotification || (() => {});
    this.onNotificationRead = options.onNotificationRead || (() => {});
    this.onCountUpdate = options.onCountUpdate || (() => {});
    
    this.socket = null;
    this.connected = false;
    this.reconnectAttempts = 0;
    this.maxReconnectAttempts = 5;
    this.reconnectDelay = 2000;
    this.token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    this.userId = this.getUserId();
    
    this.init();
  }
  
  /**
   * Get the default WebSocket URL
   * @returns {String} WebSocket URL
   */
  getDefaultWebSocketUrl() {
    const protocol = window.location.protocol === 'https:' ? 'wss:' : 'ws:';
    const host = window.location.host;
    return `${protocol}//${host}/ws/notifications`;
  }
  
  /**
   * Get the current user ID from the page
   * @returns {String|null} User ID
   */
  getUserId() {
    // Try to get user ID from meta tag
    const userIdMeta = document.querySelector('meta[name="user-id"]');
    if (userIdMeta) {
      return userIdMeta.getAttribute('content');
    }
    
    // Return null if not found
    return null;
  }
  
  /**
   * Initialize the WebSocket connection
   */
  init() {
    if (!this.userId) {
      console.warn('User ID not found, real-time notifications will not be available');
      return;
    }
    
    if (!WebSocket) {
      console.warn('WebSocket not supported by this browser');
      return;
    }
    
    this.connect();
    
    // Add event listener for user visibility change
    document.addEventListener('visibilitychange', this.handleVisibilityChange.bind(this));
  }
  
  /**
   * Connect to WebSocket server
   */
  connect() {
    try {
      // Add user ID and token to the WebSocket URL
      const urlWithParams = `${this.url}?user_id=${this.userId}&token=${this.token}`;
      
      this.socket = new WebSocket(urlWithParams);
      
      // Set up event handlers
      this.socket.onopen = this.handleOpen.bind(this);
      this.socket.onclose = this.handleClose.bind(this);
      this.socket.onerror = this.handleError.bind(this);
      this.socket.onmessage = this.handleMessage.bind(this);
    } catch (error) {
      console.error('Error connecting to notification WebSocket:', error);
      this.handleError(error);
    }
  }
  
  /**
   * Handle WebSocket open event
   * @param {Event} event - WebSocket event
   */
  handleOpen(event) {
    this.connected = true;
    this.reconnectAttempts = 0;
    console.log('Connected to notification WebSocket');
    
    // Send an initial ping message
    this.sendMessage({ type: 'ping' });
    
    // Call the onConnect callback
    this.onConnect();
  }
  
  /**
   * Handle WebSocket close event
   * @param {Event} event - WebSocket event
   */
  handleClose(event) {
    this.connected = false;
    console.log(`Notification WebSocket closed: ${event.code} ${event.reason}`);
    
    // Call the onDisconnect callback
    this.onDisconnect(event);
    
    // Attempt to reconnect if not closed intentionally
    if (event.code !== 1000 && event.code !== 1001) {
      this.attemptReconnect();
    }
  }
  
  /**
   * Handle WebSocket error event
   * @param {Event} event - WebSocket event
   */
  handleError(event) {
    console.error('Notification WebSocket error:', event);
    
    // Call the onError callback
    this.onError(event);
  }
  
  /**
   * Handle WebSocket message event
   * @param {Event} event - WebSocket event
   */
  handleMessage(event) {
    try {
      const data = JSON.parse(event.data);
      
      // Handle different message types
      switch (data.type) {
        case 'notification':
          this.handleNotification(data.notification);
          break;
        case 'notification_read':
          this.handleNotificationRead(data.notification_id);
          break;
        case 'count_update':
          this.handleCountUpdate(data.count);
          break;
        case 'pong':
          // Received pong from server
          break;
        default:
          console.log('Unknown message type:', data.type);
      }
    } catch (error) {
      console.error('Error parsing WebSocket message:', error);
    }
  }
  
  /**
   * Handle notification message
   * @param {Object} notification - Notification data
   */
  handleNotification(notification) {
    console.log('New notification received:', notification);
    
    // Play notification sound if enabled
    this.playNotificationSound();
    
    // Send desktop notification if enabled and page is not visible
    if (document.visibilityState !== 'visible') {
      this.sendDesktopNotification(notification);
    }
    
    // Call the onNotification callback
    this.onNotification(notification);
  }
  
  /**
   * Handle notification read message
   * @param {String} notificationId - ID of the read notification
   */
  handleNotificationRead(notificationId) {
    console.log('Notification marked as read:', notificationId);
    
    // Call the onNotificationRead callback
    this.onNotificationRead(notificationId);
  }
  
  /**
   * Handle count update message
   * @param {Number} count - New notification count
   */
  handleCountUpdate(count) {
    console.log('Notification count updated:', count);
    
    // Call the onCountUpdate callback
    this.onCountUpdate(count);
  }
  
  /**
   * Play notification sound
   */
  playNotificationSound() {
    // Check user preference for notification sounds
    const soundsEnabled = localStorage.getItem('nfw-notification-sounds') !== 'false';
    
    if (soundsEnabled) {
      const audio = new Audio('/assets/sounds/notification.mp3');
      audio.volume = 0.5;
      audio.play().catch(error => {
        // Browser may block autoplay
        console.warn('Could not play notification sound:', error);
      });
    }
  }
  
  /**
   * Send desktop notification
   * @param {Object} notification - Notification data
   */
  sendDesktopNotification(notification) {
    // Check if desktop notifications are supported and enabled
    if (!('Notification' in window)) {
      return;
    }
    
    // Check user preference for desktop notifications
    const desktopEnabled = localStorage.getItem('nfw-desktop-notifications') !== 'false';
    
    if (desktopEnabled && Notification.permission === 'granted') {
      const title = 'NoFoodWaste';
      const options = {
        body: notification.title || 'New notification',
        icon: '/assets/images/logo.png',
        tag: `nfw-notification-${notification.id}`,
        requireInteraction: false
      };
      
      const notif = new Notification(title, options);
      
      notif.onclick = function() {
        window.focus();
        if (notification.url) {
          window.location.href = notification.url;
        }
      };
    } else if (desktopEnabled && Notification.permission !== 'denied') {
      // Request permission if not granted or denied
      Notification.requestPermission();
    }
  }
  
  /**
   * Attempt to reconnect to WebSocket server
   */
  attemptReconnect() {
    if (this.reconnectAttempts >= this.maxReconnectAttempts) {
      console.log('Maximum reconnection attempts reached');
      return;
    }
    
    this.reconnectAttempts++;
    const delay = this.reconnectDelay * Math.pow(1.5, this.reconnectAttempts - 1);
    
    console.log(`Attempting to reconnect in ${delay}ms (attempt ${this.reconnectAttempts}/${this.maxReconnectAttempts})`);
    
    setTimeout(() => {
      if (!this.connected) {
        this.connect();
      }
    }, delay);
  }
  
  /**
   * Handle visibility change event
   */
  handleVisibilityChange() {
    if (document.visibilityState === 'visible') {
      // If the page becomes visible and we're not connected, try to reconnect
      if (!this.connected) {
        this.connect();
      }
      
      // Request notification count update
      if (this.connected) {
        this.sendMessage({ type: 'request_count' });
      }
    }
  }
  
  /**
   * Send a message to the WebSocket server
   * @param {Object} message - Message to send
   */
  sendMessage(message) {
    if (this.connected && this.socket) {
      try {
        this.socket.send(JSON.stringify(message));
      } catch (error) {
        console.error('Error sending WebSocket message:', error);
      }
    }
  }
  
  /**
   * Request to mark a notification as read
   * @param {String} notificationId - ID of the notification
   */
  markAsRead(notificationId) {
    this.sendMessage({
      type: 'mark_read',
      notification_id: notificationId
    });
  }
  
  /**
   * Request to mark all notifications as read
   */
  markAllAsRead() {
    this.sendMessage({
      type: 'mark_all_read'
    });
  }
  
  /**
   * Close the WebSocket connection
   */
  disconnect() {
    if (this.socket) {
      this.socket.close(1000, 'User disconnected');
    }
  }
}

// Export for use in other files
window.RealtimeNotifications = RealtimeNotifications;

// Initialize the real-time notification system if user is logged in
document.addEventListener('DOMContentLoaded', function() {
  const userIdMeta = document.querySelector('meta[name="user-id"]');
  
  if (userIdMeta) {
    // Get notification elements
    const notificationBox = document.querySelector('.notification-box');
    const notificationDot = document.querySelector('.dot-animated');
    const notificationCount = document.querySelector('.notification-badge');
    const notificationContent = document.querySelector('.notification-content');
    
    if (notificationBox && notificationContent) {
      // Initialize real-time notifications
      window.realtimeNotifications = new RealtimeNotifications({
        onConnect: () => {
          console.log('Connected to notification server');
        },
        onNotification: (notification) => {
          // Show notification dot
          if (notificationDot) {
            notificationDot.style.display = 'block';
          }
          
          // Update notification list if already loaded
          if (notificationContent.getAttribute('data-loaded') === 'true') {
            // Add new notification to the list
            const notificationList = notificationContent.querySelector('ul') || document.createElement('ul');
            
            const notificationItem = document.createElement('li');
            notificationItem.className = `noti-${notification.type || 'primary'}`;
            notificationItem.innerHTML = `
              <div class="media">
                <span class="notification-bg bg-light-${notification.type || 'primary'}">
                  <i data-feather="${notification.icon || 'bell'}"></i>
                </span>
                <div class="media-body">
                  <p>${notification.title || 'New notification'}</p>
                  <span>${notification.time || 'Just now'}</span>
                </div>
              </div>
            `;
            
            // Add to the beginning of the list
            notificationList.insertBefore(notificationItem, notificationList.firstChild);
            
            // Update empty state if needed
            const emptyState = notificationContent.querySelector('.empty-state');
            if (emptyState) {
              emptyState.style.display = 'none';
            }
            
            // Init Feather icons for the new element
            if (window.feather) {
              window.feather.replace({
                'scope': notificationItem
              });
            }
          }
          
          // Update count
          if (notificationCount) {
            const currentCount = parseInt(notificationCount.textContent) || 0;
            notificationCount.textContent = currentCount + 1;
          }
        },
        onCountUpdate: (count) => {
          // Update notification count
          if (notificationCount) {
            notificationCount.textContent = count;
          }
          
          // Show/hide notification dot
          if (notificationDot) {
            notificationDot.style.display = count > 0 ? 'block' : 'none';
          }
          
          // Update screen reader text
          const srCount = document.querySelector('.notification-count.sr-only');
          if (srCount) {
            srCount.textContent = `${count} new notifications`;
          }
        }
      });
    }
  }
});

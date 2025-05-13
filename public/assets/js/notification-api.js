/**
 * NoFoodWaste Notification API
 * Handles notification-related functions
 * Created: May 13, 2025
 */

class NotificationAPI {
  constructor() {
    this.baseUrl = '/api/notifications';
    this.token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
  }

  /**
   * Fetch user notifications
   * @param {Number} limit - Number of notifications to fetch
   * @returns {Promise} - Promise that resolves to notification data
   */
  async getNotifications(limit = 5) {
    try {
      const response = await fetch(`${this.baseUrl}?limit=${limit}`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': this.token,
          'Accept': 'application/json'
        }
      });

      if (!response.ok) {
        throw new Error('Failed to fetch notifications');
      }

      return await response.json();
    } catch (error) {
      console.error('Error fetching notifications:', error);
      return {
        success: false,
        message: error.message,
        data: []
      };
    }
  }

  /**
   * Mark a notification as read
   * @param {String} id - Notification ID
   * @returns {Promise} - Promise that resolves to response data
   */
  async markAsRead(id) {
    try {
      const response = await fetch(`${this.baseUrl}/${id}/read`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': this.token,
          'Accept': 'application/json'
        }
      });

      if (!response.ok) {
        throw new Error('Failed to mark notification as read');
      }

      return await response.json();
    } catch (error) {
      console.error('Error marking notification as read:', error);
      return {
        success: false,
        message: error.message
      };
    }
  }

  /**
   * Mark all notifications as read
   * @returns {Promise} - Promise that resolves to response data
   */
  async markAllAsRead() {
    try {
      const response = await fetch(`${this.baseUrl}/read-all`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': this.token,
          'Accept': 'application/json'
        }
      });

      if (!response.ok) {
        throw new Error('Failed to mark all notifications as read');
      }

      return await response.json();
    } catch (error) {
      console.error('Error marking all notifications as read:', error);
      return {
        success: false,
        message: error.message
      };
    }
  }

  /**
   * Get notification count
   * @returns {Promise} - Promise that resolves to notification count
   */
  async getCount() {
    try {
      const response = await fetch(`${this.baseUrl}/count`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': this.token,
          'Accept': 'application/json'
        }
      });

      if (!response.ok) {
        throw new Error('Failed to fetch notification count');
      }

      return await response.json();
    } catch (error) {
      console.error('Error fetching notification count:', error);
      return {
        success: false,
        message: error.message,
        count: 0
      };
    }
  }
}

// Export for use in other files
window.NotificationAPI = new NotificationAPI();

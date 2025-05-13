/**
 * NoFoodWaste Notification API Integration Tests
 * Tests the notification API functionality
 * Created: May 20, 2025
 */

class NotificationAPITester {
  constructor() {
    this.api = window.NotificationAPI;
    this.testResults = {
      passed: 0,
      failed: 0,
      total: 0
    };
    this.consoleStyles = {
      pass: 'color: green; font-weight: bold;',
      fail: 'color: red; font-weight: bold;',
      info: 'color: blue; font-style: italic;',
      summary: 'color: purple; font-weight: bold; font-size: 14px;'
    };
  }

  /**
   * Run all tests
   */
  async runAllTests() {
    console.log('%c📋 Starting NotificationAPI Integration Tests...', this.consoleStyles.info);
    
    // List of tests to run
    const tests = [
      this.testGetNotifications.bind(this),
      this.testGetCount.bind(this),
      this.testMarkAsRead.bind(this),
      this.testMarkAllAsRead.bind(this),
      this.testErrorHandling.bind(this)
    ];

    // Run each test
    for (const test of tests) {
      await test();
    }

    // Log summary
    this.logSummary();
  }

  /**
   * Log test result
   * @param {String} testName - Name of the test
   * @param {Boolean} passed - Whether the test passed
   * @param {String} message - Additional message
   */
  logTestResult(testName, passed, message = '') {
    this.testResults.total++;
    
    if (passed) {
      this.testResults.passed++;
      console.log(`%c✅ PASS: ${testName}`, this.consoleStyles.pass, message);
    } else {
      this.testResults.failed++;
      console.log(`%c❌ FAIL: ${testName}`, this.consoleStyles.fail, message);
    }
  }

  /**
   * Log test summary
   */
  logSummary() {
    const { passed, failed, total } = this.testResults;
    const style = this.consoleStyles.summary;
    
    console.log(
      `%c📊 Test Summary: ${passed} passed, ${failed} failed, ${total} total (${Math.round((passed/total) * 100)}% success)`,
      style
    );
  }

  /**
   * Test getNotifications method
   */
  async testGetNotifications() {
    try {
      const result = await this.api.getNotifications(3);
      const hasCorrectStructure = 
        result && 
        typeof result.success === 'boolean' && 
        Array.isArray(result.data);
      
      this.logTestResult(
        'getNotifications()', 
        hasCorrectStructure, 
        hasCorrectStructure ? `Received ${result.data.length} notifications` : 'Invalid response structure'
      );
    } catch (error) {
      this.logTestResult('getNotifications()', false, error.message);
    }
  }

  /**
   * Test getCount method
   */
  async testGetCount() {
    try {
      const result = await this.api.getCount();
      const hasCorrectStructure = 
        result && 
        typeof result.success === 'boolean' && 
        typeof result.count === 'number';
      
      this.logTestResult(
        'getCount()', 
        hasCorrectStructure, 
        hasCorrectStructure ? `Count: ${result.count}` : 'Invalid response structure'
      );
    } catch (error) {
      this.logTestResult('getCount()', false, error.message);
    }
  }

  /**
   * Test markAsRead method
   */
  async testMarkAsRead() {
    try {
      // First get a notification to mark as read
      const notificationsResult = await this.api.getNotifications(1);
      
      if (!notificationsResult.success || !notificationsResult.data.length) {
        this.logTestResult('markAsRead()', false, 'No notifications available to test with');
        return;
      }
      
      const notificationId = notificationsResult.data[0].id;
      const result = await this.api.markAsRead(notificationId);
      
      const hasCorrectStructure = 
        result && 
        typeof result.success === 'boolean';
      
      this.logTestResult(
        'markAsRead()', 
        hasCorrectStructure && result.success, 
        `Notification ${notificationId} marked as read`
      );
    } catch (error) {
      this.logTestResult('markAsRead()', false, error.message);
    }
  }

  /**
   * Test markAllAsRead method
   */
  async testMarkAllAsRead() {
    try {
      const result = await this.api.markAllAsRead();
      
      const hasCorrectStructure = 
        result && 
        typeof result.success === 'boolean';
      
      this.logTestResult(
        'markAllAsRead()', 
        hasCorrectStructure && result.success, 
        'All notifications marked as read'
      );
    } catch (error) {
      this.logTestResult('markAllAsRead()', false, error.message);
    }
  }

  /**
   * Test error handling
   */
  async testErrorHandling() {
    // Temporarily override fetch function to simulate errors
    const originalFetch = window.fetch;
    
    try {
      // Simulate network error
      window.fetch = () => Promise.reject(new Error('Network error'));
      
      const result = await this.api.getNotifications();
      
      const handlesErrorCorrectly = 
        result && 
        result.success === false && 
        typeof result.message === 'string';
      
      this.logTestResult(
        'Error handling (network error)', 
        handlesErrorCorrectly, 
        handlesErrorCorrectly ? `Error message: ${result.message}` : 'Did not handle error correctly'
      );
    } catch (error) {
      this.logTestResult('Error handling (network error)', false, 'Exception not caught: ' + error.message);
    } finally {
      // Restore original fetch
      window.fetch = originalFetch;
    }
    
    try {
      // Simulate server error
      window.fetch = () => Promise.resolve({
        ok: false,
        status: 500,
        json: () => Promise.resolve({ message: 'Server error' })
      });
      
      const result = await this.api.getCount();
      
      const handlesErrorCorrectly = 
        result && 
        result.success === false && 
        typeof result.message === 'string';
      
      this.logTestResult(
        'Error handling (server error)', 
        handlesErrorCorrectly, 
        handlesErrorCorrectly ? `Error message: ${result.message}` : 'Did not handle error correctly'
      );
    } catch (error) {
      this.logTestResult('Error handling (server error)', false, 'Exception not caught: ' + error.message);
    } finally {
      // Restore original fetch
      window.fetch = originalFetch;
    }
  }
}

// Test runner - will run when included in a page
document.addEventListener('DOMContentLoaded', function() {
  // Check if we're in test mode
  if (window.location.search.includes('run_api_tests=true')) {
    console.log('%c🧪 Running Notification API Integration Tests...', 'color:purple;font-size:14px;');
    const tester = new NotificationAPITester();
    tester.runAllTests();
  }
});

// Export for use in browser console
window.NotificationAPITester = NotificationAPITester;

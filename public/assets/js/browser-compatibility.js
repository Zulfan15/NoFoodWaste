/**
 * NoFoodWaste Browser Compatibility Checker
 * Detects browser features and provides compatibility info
 * Created: May 20, 2025
 */

class BrowserCompatibilityChecker {
  constructor() {
    this.browserInfo = this.getBrowserInfo();
    this.featureSupport = this.checkFeatureSupport();
  }

  /**
   * Get browser information
   * @returns {Object} Browser name, version, and platform
   */
  getBrowserInfo() {
    const ua = navigator.userAgent;
    let browser = 'Unknown';
    let version = 'Unknown';
    let platform = navigator.platform || 'Unknown';
    
    // Check for common browsers
    if (ua.indexOf('Firefox') > -1) {
      browser = 'Firefox';
      version = ua.match(/Firefox\/([\d.]+)/)[1];
    } else if (ua.indexOf('Edge') > -1 || ua.indexOf('Edg/') > -1) {
      browser = 'Edge';
      version = ua.match(/Edge\/([\d.]+)/) || ua.match(/Edg\/([\d.]+)/);
      version = version ? version[1] : 'Unknown';
    } else if (ua.indexOf('Chrome') > -1 && ua.indexOf('Edg') === -1) {
      browser = 'Chrome';
      version = ua.match(/Chrome\/([\d.]+)/)[1];
    } else if (ua.indexOf('Safari') > -1 && ua.indexOf('Chrome') === -1) {
      browser = 'Safari';
      version = ua.match(/Version\/([\d.]+)/);
      version = version ? version[1] : 'Unknown';
    } else if (ua.indexOf('MSIE') > -1 || ua.indexOf('Trident/') > -1) {
      browser = 'Internet Explorer';
      version = ua.match(/MSIE ([\d.]+)/) || 'Unknown';
      if (version !== 'Unknown') version = version[1];
    } else if (ua.indexOf('Opera') > -1 || ua.indexOf('OPR/') > -1) {
      browser = 'Opera';
      version = ua.match(/Opera\/([\d.]+)/) || ua.match(/OPR\/([\d.]+)/);
      version = version ? version[1] : 'Unknown';
    }
    
    return { browser, version, platform };
  }

  /**
   * Check browser support for features used in the header
   * @returns {Object} Object with feature support information
   */
  checkFeatureSupport() {
    return {
      flexbox: this.testFlexbox(),
      css_variables: this.testCSSVariables(),
      localStorage: this.testLocalStorage(),
      fetch_api: this.testFetchAPI(),
      promise: this.testPromise(),
      css_transitions: this.testCSSTransitions(),
      touch_events: this.testTouchEvents(),
      css_grid: this.testCSSGrid(),
      webp: this.testWebP(),
      websocket: this.testWebSocket(),
      intersection_observer: this.testIntersectionObserver(),
      media_queries: this.testMediaQueries(),
      prefers_reduced_motion: this.testPrefersReducedMotion(),
      prefers_color_scheme: this.testPrefersColorScheme()
    };
  }

  /**
   * Test support for flexbox
   * @returns {Boolean} Whether flexbox is supported
   */
  testFlexbox() {
    const div = document.createElement('div');
    return (
      'flexBasis' in div.style ||
      'webkitFlexBasis' in div.style ||
      'mozFlexBasis' in div.style
    );
  }

  /**
   * Test support for CSS variables
   * @returns {Boolean} Whether CSS variables are supported
   */
  testCSSVariables() {
    return window.CSS && CSS.supports && CSS.supports('--a', '0');
  }

  /**
   * Test support for localStorage
   * @returns {Boolean} Whether localStorage is supported
   */
  testLocalStorage() {
    try {
      const test = 'test';
      localStorage.setItem(test, test);
      localStorage.removeItem(test);
      return true;
    } catch (e) {
      return false;
    }
  }

  /**
   * Test support for fetch API
   * @returns {Boolean} Whether fetch API is supported
   */
  testFetchAPI() {
    return 'fetch' in window;
  }

  /**
   * Test support for Promise
   * @returns {Boolean} Whether Promise is supported
   */
  testPromise() {
    return 'Promise' in window;
  }

  /**
   * Test support for CSS transitions
   * @returns {Boolean} Whether CSS transitions are supported
   */
  testCSSTransitions() {
    const div = document.createElement('div');
    return (
      'transition' in div.style ||
      'webkitTransition' in div.style ||
      'mozTransition' in div.style
    );
  }

  /**
   * Test support for touch events
   * @returns {Boolean} Whether touch events are supported
   */
  testTouchEvents() {
    return 'ontouchstart' in window || navigator.maxTouchPoints > 0;
  }

  /**
   * Test support for CSS grid
   * @returns {Boolean} Whether CSS grid is supported
   */
  testCSSGrid() {
    return window.CSS && CSS.supports && CSS.supports('display', 'grid');
  }

  /**
   * Test support for WebP images
   * @returns {Promise<Boolean>} Whether WebP is supported
   */
  testWebP() {
    return new Promise(resolve => {
      const webP = new Image();
      webP.src = 'data:image/webp;base64,UklGRjoAAABXRUJQVlA4IC4AAACyAgCdASoCAAIALmk0mk0iIiIiIgBoSygABc6WWgAA/veff/0PP8bA//LwYAAA';
      webP.onload = webP.onerror = () => {
        resolve(webP.height === 2);
      };
    });
  }

  /**
   * Test support for WebSocket
   * @returns {Boolean} Whether WebSocket is supported
   */
  testWebSocket() {
    return 'WebSocket' in window;
  }

  /**
   * Test support for Intersection Observer
   * @returns {Boolean} Whether Intersection Observer is supported
   */
  testIntersectionObserver() {
    return 'IntersectionObserver' in window;
  }

  /**
   * Test support for media queries
   * @returns {Boolean} Whether media queries are supported
   */
  testMediaQueries() {
    return 'matchMedia' in window;
  }

  /**
   * Test support for prefers-reduced-motion media query
   * @returns {Boolean} Whether prefers-reduced-motion is supported
   */
  testPrefersReducedMotion() {
    return window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').media !== 'not all';
  }

  /**
   * Test support for prefers-color-scheme media query
   * @returns {Boolean} Whether prefers-color-scheme is supported
   */
  testPrefersColorScheme() {
    return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').media !== 'not all';
  }

  /**
   * Generate a report of browser compatibility
   * @returns {Object} Compatibility report
   */
  generateReport() {
    const { browser, version, platform } = this.browserInfo;
    const features = this.featureSupport;
    
    // Count supported features
    const supportedFeatures = Object.values(features).filter(value => 
      value === true || value === Promise.resolve(true)
    ).length;
    
    const totalFeatures = Object.keys(features).length;
    const compatibilityScore = (supportedFeatures / totalFeatures) * 100;
    
    // Determine compatibility status
    let compatibilityStatus = 'Unknown';
    if (compatibilityScore >= 90) {
      compatibilityStatus = 'Fully Compatible';
    } else if (compatibilityScore >= 75) {
      compatibilityStatus = 'Mostly Compatible';
    } else if (compatibilityScore >= 50) {
      compatibilityStatus = 'Partially Compatible';
    } else {
      compatibilityStatus = 'Not Compatible';
    }
    
    return {
      browser,
      version,
      platform,
      compatibilityScore: Math.round(compatibilityScore),
      compatibilityStatus,
      featureSupport: features
    };
  }

  /**
   * Display compatibility information on the page
   */
  displayCompatibilityInfo() {
    const report = this.generateReport();
    
    // Create element to display information
    const infoDiv = document.createElement('div');
    infoDiv.id = 'browser-compatibility-info';
    infoDiv.style.position = 'fixed';
    infoDiv.style.bottom = '20px';
    infoDiv.style.right = '20px';
    infoDiv.style.backgroundColor = '#fff';
    infoDiv.style.border = '1px solid #ccc';
    infoDiv.style.padding = '15px';
    infoDiv.style.borderRadius = '5px';
    infoDiv.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
    infoDiv.style.zIndex = '9999';
    infoDiv.style.maxWidth = '400px';
    infoDiv.style.fontSize = '14px';
    
    // Create close button
    const closeButton = document.createElement('button');
    closeButton.textContent = '×';
    closeButton.style.position = 'absolute';
    closeButton.style.top = '5px';
    closeButton.style.right = '8px';
    closeButton.style.border = 'none';
    closeButton.style.background = 'none';
    closeButton.style.fontSize = '20px';
    closeButton.style.cursor = 'pointer';
    closeButton.style.color = '#666';
    closeButton.addEventListener('click', () => infoDiv.remove());
    
    // Add content
    const scoreColor = report.compatibilityScore >= 90 ? 'green' : 
                       report.compatibilityScore >= 75 ? 'orange' : 'red';
    
    infoDiv.innerHTML = `
      <h3 style="margin-top: 0; margin-bottom: 10px; font-size: 16px;">Browser Compatibility Test</h3>
      <p><strong>Browser:</strong> ${report.browser} ${report.version}</p>
      <p><strong>Platform:</strong> ${report.platform}</p>
      <p><strong>Compatibility Score:</strong> <span style="color: ${scoreColor}; font-weight: bold;">${report.compatibilityScore}%</span></p>
      <p><strong>Status:</strong> ${report.compatibilityStatus}</p>
      <details>
        <summary style="cursor: pointer; margin-bottom: 5px;">Feature Support Details</summary>
        <ul style="margin: 5px 0; padding-left: 20px;">
          ${Object.entries(report.featureSupport)
            .map(([feature, supported]) => {
              const formattedFeature = feature.replace(/_/g, ' ');
              if (supported === true) {
                return `<li style="color: green;">${formattedFeature} ✅</li>`;
              } else if (supported === false) {
                return `<li style="color: red;">${formattedFeature} ❌</li>`;
              } else if (supported instanceof Promise) {
                return `<li>${formattedFeature} ⏳</li>`;
              } else {
                return `<li>${formattedFeature} ❓</li>`;
              }
            })
            .join('')}
        </ul>
      </details>
    `;
    
    infoDiv.appendChild(closeButton);
    document.body.appendChild(infoDiv);
  }
}

// Initialize and expose globally
window.BrowserCompatibilityChecker = BrowserCompatibilityChecker;

// Run compatibility check when URL has a specific parameter
document.addEventListener('DOMContentLoaded', function() {
  if (window.location.search.includes('check_compatibility=true')) {
    const checker = new BrowserCompatibilityChecker();
    checker.displayCompatibilityInfo();
  }
});

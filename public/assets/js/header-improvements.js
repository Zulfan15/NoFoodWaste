/**
 * NoFoodWaste Header Improvements
 * Enhanced functionality for the header component
 * Created: May 20, 2025
 */

document.addEventListener('DOMContentLoaded', function() {
  // Check if the browser compatibility utility is needed
  if (window.BrowserCompatibilityChecker) {
    // Auto-run on URL parameter or store for manual checking
    window.browserChecker = new BrowserCompatibilityChecker();
  }

  // Mobile menu toggle functionality
  const mobileToggle = document.querySelector('.mobile-toggle');
  const navMenus = document.querySelector('.nav-right > ul');
  
  if (mobileToggle && navMenus) {
    mobileToggle.addEventListener('click', function() {
      navMenus.classList.toggle('open');
      
      // Update ARIA expanded state
      const isExpanded = navMenus.classList.contains('open');
      mobileToggle.setAttribute('aria-expanded', isExpanded);
    });
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
      if (!event.target.closest('.nav-right') && 
          !event.target.closest('.mobile-toggle') && 
          navMenus.classList.contains('open')) {
        navMenus.classList.remove('open');
        mobileToggle.setAttribute('aria-expanded', 'false');
      }
    });
  }
  
  // Toggle sidebar button functionality (enhancement)
  const toggleSidebar = document.querySelector('.toggle-sidebar');
  if (toggleSidebar) {
    toggleSidebar.addEventListener('click', function() {
      const bodyElement = document.querySelector('body');
      if (bodyElement) {
        bodyElement.classList.toggle('sidebar-close');
        // Update ARIA expanded state
        const isExpanded = !bodyElement.classList.contains('sidebar-close');
        toggleSidebar.setAttribute('aria-expanded', isExpanded);
      }
    });
  }
  
  // Dark mode toggle functionality
  const darkModeToggle = document.querySelector('.mode');
  if (darkModeToggle) {
    // Check for saved preference
    const isDarkMode = localStorage.getItem('nfw-dark-mode') === 'true';
    
    // Apply saved preference
    if (isDarkMode) {
      document.body.classList.add('dark-mode');
      darkModeToggle.setAttribute('aria-pressed', 'true');
    } else {
      darkModeToggle.setAttribute('aria-pressed', 'false');
    }
    
    darkModeToggle.addEventListener('click', function() {
      // Toggle dark mode class
      document.body.classList.toggle('dark-mode');
      
      // Update ARIA state
      const isDarkMode = document.body.classList.contains('dark-mode');
      darkModeToggle.setAttribute('aria-pressed', isDarkMode);
      
      // Save preference
      localStorage.setItem('nfw-dark-mode', isDarkMode);
    });
  }  
  // Enhanced keyboard navigation for dropdowns
  const dropdowns = document.querySelectorAll('.onhover-dropdown');
  
  dropdowns.forEach(dropdown => {
    const triggerButton = dropdown.querySelector('button');
    const dropdownMenu = dropdown.querySelector('.onhover-show-div');
    
    if (triggerButton && dropdownMenu) {
      // Make sure dropdown works with keyboard
      triggerButton.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          
          // Toggle aria-expanded
          const isExpanded = triggerButton.getAttribute('aria-expanded') === 'true';
          triggerButton.setAttribute('aria-expanded', !isExpanded);
          
          // Toggle visibility class
          dropdownMenu.classList.toggle('show');
          
          // Focus first item if opened
          if (!isExpanded) {
            const firstItem = dropdownMenu.querySelector('a');
            if (firstItem) {
              setTimeout(() => firstItem.focus(), 100);
            }
          }
        }
      });
      
      // Close dropdown when Escape is pressed
      dropdownMenu.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
          triggerButton.setAttribute('aria-expanded', 'false');
          dropdownMenu.classList.remove('show');
          triggerButton.focus();
        }
      });
    }
  });
  
  // Focus trap for accessible dropdowns
  function trapFocus(element) {
    const focusableElements = element.querySelectorAll(
      'a[href], button, textarea, input[type="text"], input[type="radio"], input[type="checkbox"], select'
    );
    
    if (focusableElements.length) {
      const firstElement = focusableElements[0];
      const lastElement = focusableElements[focusableElements.length - 1];
      
      element.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
          // Shift+Tab on first element should loop to last
          if (e.shiftKey && document.activeElement === firstElement) {
            e.preventDefault();
            lastElement.focus();
          } 
          // Tab on last element should loop to first
          else if (!e.shiftKey && document.activeElement === lastElement) {
            e.preventDefault();
            firstElement.focus();
          }
        }
      });
    }
  }
  
  // Apply focus trap to all dropdown menus
  document.querySelectorAll('.onhover-show-div').forEach(trapFocus);
  
  // Show/hide CSS class for keyboard users
  document.querySelectorAll('.onhover-dropdown').forEach(dropdown => {
    const button = dropdown.querySelector('button');
    const menu = dropdown.querySelector('.onhover-show-div');
    
    if (button && menu) {
      button.addEventListener('click', function() {
        menu.classList.toggle('show');
        const isExpanded = menu.classList.contains('show');
        button.setAttribute('aria-expanded', isExpanded);
      });
    }
  });
    // Add full-screen toggle functionality
  const fullscreenButton = document.querySelector('[aria-label="Toggle Fullscreen"]');
  if (fullscreenButton) {
    fullscreenButton.addEventListener('click', function() {
      if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen().catch(err => {
          console.error(`Error attempting to enable full-screen mode: ${err.message}`);
        });
      } else {
        if (document.exitFullscreen) {
          document.exitFullscreen();
        }
      }
    });
  }
    // Add touch support for mobile devices
  document.querySelectorAll('.onhover-dropdown').forEach(dropdown => {
    const button = dropdown.querySelector('button');
    const menu = dropdown.querySelector('.onhover-show-div');
    
    if (button && menu) {
      // For touch devices, handle tap events
      let touchTimer;
      let touchDuration = 500; // Duration threshold for long tap
      
      button.addEventListener('touchstart', function(e) {
        touchTimer = setTimeout(function() {
          menu.classList.add('show');
          button.setAttribute('aria-expanded', 'true');
        }, touchDuration);
      });
      
      button.addEventListener('touchend', function(e) {
        if (touchTimer) {
          clearTimeout(touchTimer);
        }
      });
      
      button.addEventListener('touchmove', function(e) {
        if (touchTimer) {
          clearTimeout(touchTimer);
        }
      });
      
      // Handle touches outside the dropdown to close it
      document.addEventListener('touchstart', function(e) {
        if (!dropdown.contains(e.target) && menu.classList.contains('show')) {
          menu.classList.remove('show');
          button.setAttribute('aria-expanded', 'false');
        }
      });
    }
  });    // Lazy load notifications
  const notificationBox = document.querySelector('.main-header-left .notification-box');
  const notificationContent = document.querySelector('.main-header-left .notification-content');
  const notificationLoading = document.querySelector('.main-header-left .noti-loading');
  const notificationDot = document.querySelector('.main-header-left .dot-animated');
  
  if (notificationBox && notificationContent) {
    // Load notifications when dropdown is opened
    notificationBox.addEventListener('click', function() {
      // Check if notifications are already loaded
      if (notificationContent.getAttribute('data-loaded') !== 'true') {
        loadNotifications();
      }
    });
    
    // Also load on hover for desktop
    notificationBox.addEventListener('mouseenter', function() {
      if (notificationContent.getAttribute('data-loaded') !== 'true') {
        loadNotifications();
      }
    });
    
    // Function to load notifications using our API
    function loadNotifications() {
      // Show loading spinner
      if (notificationLoading) {
        notificationLoading.style.display = 'block';
      }
      
      // Check if the notification API is available
      if (window.NotificationAPI) {
        // Get notifications from API
        window.NotificationAPI.getNotifications(5)
          .then(response => {
            if (response.success && response.data.length > 0) {
              // Create notification HTML
              renderNotifications(response.data);
            } else {
              // Show empty state
              renderEmptyState();
            }
            
            // Mark as loaded
            notificationContent.setAttribute('data-loaded', 'true');
            
            // Hide loading spinner
            if (notificationLoading) {
              notificationLoading.style.display = 'none';
            }
          })
          .catch(error => {
            console.error('Error loading notifications:', error);
            renderErrorState();
            
            // Hide loading spinner
            if (notificationLoading) {
              notificationLoading.style.display = 'none';
            }
          });
      } else {
        // Fallback for when API is not available
        setTimeout(function() {
          // Simulate getting notifications
          const mockNotifications = [
            { id: 1, type: 'primary', icon: 'activity', title: 'Delivery processing', time: '10 minutes ago' },
            { id: 2, type: 'secondary', icon: 'check-circle', title: 'Order Complete', time: '1 hour ago' },
            { id: 3, type: 'success', icon: 'file-text', title: 'Tickets Generated', time: '3 hours ago' },
            { id: 4, type: 'danger', icon: 'user-check', title: 'Delivery Complete', time: '6 hours ago' }
          ];
          
          renderNotifications(mockNotifications);
          
          // Mark as loaded
          notificationContent.setAttribute('data-loaded', 'true');
          
          // Hide loading spinner
          if (notificationLoading) {
            notificationLoading.style.display = 'none';
          }
        }, 500);
      }
    }
      // Function to render notifications
    function renderNotifications(notifications) {
      // Check if we have the virtual list module available
      if (window.VirtualNotificationList && notifications.length > 10) {
        // Clear existing content
        notificationContent.innerHTML = '';
        
        // Create container for virtual list
        const virtualListContainer = document.createElement('div');
        virtualListContainer.className = 'virtual-notification-container';
        virtualListContainer.style.height = '300px'; // Max height
        notificationContent.appendChild(virtualListContainer);
        
        // Initialize virtual list
        const virtualList = new VirtualNotificationList({
          container: virtualListContainer,
          itemHeight: 65, // Approximate height of each notification item
          bufferItems: 3,
          renderItem: (notification, index) => {
            const itemElement = document.createElement('li');
            itemElement.className = `noti-${notification.type || 'primary'}`;
            itemElement.innerHTML = `
              <div class="media">
                <span class="notification-bg bg-light-${notification.type || 'primary'}">
                  <i data-feather="${notification.icon || 'bell'}"></i>
              </span>
              <div class="media-body">
                <p>${notification.title}</p>
                <span>${notification.time}</span>
              </div>
            </div>
          </li>
        `;
            return itemElement;
          }
        });
      }
      
      let html = '';
      
      // Add mark all as read button
      html += `
        <li class="text-center p-2">
          <button class="btn btn-primary btn-sm mark-all-read">Mark All as Read</button>
        </li>
      `;
      
        notificationContent.innerHTML = html;
        
        // Re-initialize feather icons
        if (window.feather) {
          window.feather.replace();
        }
        
        // Add event listener to mark all as read button
        const markAllReadBtn = notificationContent.querySelector('.mark-all-read');
        if (markAllReadBtn) {
          markAllReadBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (window.NotificationAPI) {
              window.NotificationAPI.markAllAsRead()
                .then(response => {
                  if (response.success) {
                    // Hide notification dot
                    if (notificationDot) {
                      notificationDot.style.display = 'none';
                    }
                    
                    // Close dropdown
                    const dropdown = notificationBox.closest('.onhover-dropdown');
                    if (dropdown) {
                      const dropdownMenu = dropdown.querySelector('.onhover-show-div');
                      if (dropdownMenu) {
                        dropdownMenu.classList.remove('show');
                      }
                    }
                  }
                })
                .catch(error => {
                  console.error('Error marking all as read:', error);
                });
            } else {
              // Fallback for when API is not available
              if (notificationDot) {
                notificationDot.style.display = 'none';
              }
            }
          });
        }
      }
      
      // Function to render empty state
    function renderEmptyState() {
      const html = `
        <li class="text-center p-3">
          <div class="empty-state">
            <i data-feather="bell-off" class="mb-2"></i>
            <p>Tidak ada notifikasi baru</p>
          </div>
        </li>
      `;
      
      notificationContent.innerHTML = html;
      
      // Re-initialize feather icons
      if (window.feather) {
        window.feather.replace();
      }
    }
    
    // Function to render error state
    function renderErrorState() {
      const html = `
        <li class="text-center p-3">
          <div class="error-state text-danger">
            <i data-feather="alert-circle" class="mb-2"></i>
            <p>Gagal memuat notifikasi</p>
            <button class="btn btn-outline-primary btn-sm retry-load mt-2">Coba Lagi</button>
          </div>
        </li>
      `;
      
      notificationContent.innerHTML = html;
      
      // Re-initialize feather icons
      if (window.feather) {
        window.feather.replace();
      }
      
      // Add event listener to retry button
      const retryBtn = notificationContent.querySelector('.retry-load');
      if (retryBtn) {
        retryBtn.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          
          // Reset loaded state
          notificationContent.setAttribute('data-loaded', 'false');
          
          // Reload notifications
          loadNotifications();
        });
      }
    }
    
    // Check notification count on page load
    function checkNotificationCount() {
      if (window.NotificationAPI && notificationDot) {
        window.NotificationAPI.getCount()
          .then(response => {
            if (response.success && response.count > 0) {
              // Show notification dot
              notificationDot.style.display = 'block';
              
              // Update count in header if element exists
              const countBadge = document.querySelector('.notification-count');
              if (countBadge) {
                countBadge.textContent = response.count;
              }
            } else {
              // Hide notification dot
              notificationDot.style.display = 'none';
            }
          })
          .catch(error => {
            console.error('Error checking notification count:', error);
          });
      }
    }
    
    // Check notification count on page load
    checkNotificationCount();
    
    // Poll for new notifications every minute
    setInterval(checkNotificationCount, 60000);
  }
});

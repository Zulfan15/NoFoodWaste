// Mobile Menu Functionality Test
// This JavaScript code validates the mobile menu functionality

document.addEventListener('DOMContentLoaded', function() {
  console.log('Testing mobile menu functionality...');
  
  // Check if mobile toggle and nav menus exist
  const mobileToggle = document.querySelector('.mobile-toggle');
  const navMenus = document.querySelector('.nav-right > ul');
  
  if (mobileToggle && navMenus) {
    console.log('Mobile toggle and nav menus found');
    
    // Log initial state
    console.log('Initial mobile menu state:', navMenus.classList.contains('open') ? 'open' : 'closed');
    console.log('Initial aria-expanded state:', mobileToggle.getAttribute('aria-expanded'));
    
    // Test toggling
    mobileToggle.click();
    console.log('After click, mobile menu state:', navMenus.classList.contains('open') ? 'open' : 'closed');
    console.log('After click, aria-expanded state:', mobileToggle.getAttribute('aria-expanded'));
    
    // Reset state
    if (navMenus.classList.contains('open')) {
      mobileToggle.click();
    }
  } else {
    console.error('Mobile toggle or nav menus not found');
  }
  
  // Check dropdown functionality
  const dropdowns = document.querySelectorAll('.onhover-dropdown');
  console.log('Found', dropdowns.length, 'dropdowns');
  
  dropdowns.forEach((dropdown, index) => {
    const trigger = dropdown.querySelector('button');
    const menu = dropdown.querySelector('.onhover-show-div');
    
    if (trigger && menu) {
      console.log(`Dropdown ${index + 1}: Trigger and menu found`);
    } else {
      console.error(`Dropdown ${index + 1}: Missing trigger or menu`);
    }
  });
});

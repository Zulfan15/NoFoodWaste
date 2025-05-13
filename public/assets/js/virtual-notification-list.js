/**
 * NoFoodWaste Virtual Notification List
 * Optimizes performance for large notification lists using virtual scrolling
 * Created: May 20, 2025
 */

class VirtualNotificationList {
  /**
   * Initialize the virtual notification list
   * @param {Object} options - Configuration options
   * @param {HTMLElement} options.container - The container element
   * @param {Function} options.renderItem - Function to render a single item
   * @param {Number} options.itemHeight - Height of each item in pixels
   * @param {Number} options.bufferItems - Number of items to render above/below viewport
   */
  constructor(options) {
    this.container = options.container;
    this.renderItem = options.renderItem;
    this.itemHeight = options.itemHeight || 60;
    this.bufferItems = options.bufferItems || 5;
    
    this.items = [];
    this.visibleItems = [];
    this.scrollTop = 0;
    this.startIndex = 0;
    this.endIndex = 0;
    this.viewportHeight = 0;
    
    this.virtualScrollContainer = null;
    this.virtualContent = null;
    
    this.initialize();
  }
  
  /**
   * Initialize the virtual list
   */
  initialize() {
    // Create the structure
    this.createDOMStructure();
    
    // Add scroll event listener
    this.virtualScrollContainer.addEventListener('scroll', this.handleScroll.bind(this));
    
    // Add resize event listener
    window.addEventListener('resize', this.handleResize.bind(this));
    
    // Initial measurements
    this.updateViewportHeight();
  }
  
  /**
   * Create the DOM structure for virtual scrolling
   */
  createDOMStructure() {
    // Clear container
    this.container.innerHTML = '';
    
    // Create virtual scroll container
    this.virtualScrollContainer = document.createElement('div');
    this.virtualScrollContainer.className = 'virtual-scroll-container';
    this.virtualScrollContainer.style.cssText = `
      height: 100%;
      overflow-y: auto;
      position: relative;
    `;
    
    // Create virtual content that will hold the actual items
    this.virtualContent = document.createElement('div');
    this.virtualContent.className = 'virtual-content';
    this.virtualContent.style.cssText = `
      position: relative;
      width: 100%;
    `;
    
    // Append to the DOM
    this.virtualScrollContainer.appendChild(this.virtualContent);
    this.container.appendChild(this.virtualScrollContainer);
  }
  
  /**
   * Update the list with new items
   * @param {Array} items - New items to display
   */
  updateItems(items) {
    this.items = items;
    
    // Update the height of the content
    this.virtualContent.style.height = `${this.items.length * this.itemHeight}px`;
    
    // Render the initial view
    this.render();
  }
  
  /**
   * Handle scroll events
   */
  handleScroll() {
    this.scrollTop = this.virtualScrollContainer.scrollTop;
    this.render();
  }
  
  /**
   * Handle window resize events
   */
  handleResize() {
    this.updateViewportHeight();
    this.render();
  }
  
  /**
   * Update the viewport height
   */
  updateViewportHeight() {
    this.viewportHeight = this.virtualScrollContainer.clientHeight;
    this.render();
  }
  
  /**
   * Calculate which items should be visible
   */
  updateVisibleItems() {
    // Calculate the start index based on scroll position
    this.startIndex = Math.max(0, Math.floor(this.scrollTop / this.itemHeight) - this.bufferItems);
    
    // Calculate the end index based on viewport height
    const visibleCount = Math.ceil(this.viewportHeight / this.itemHeight) + (this.bufferItems * 2);
    this.endIndex = Math.min(this.items.length - 1, this.startIndex + visibleCount);
    
    // Get the items that should be visible
    this.visibleItems = this.items.slice(this.startIndex, this.endIndex + 1);
  }
  
  /**
   * Render the visible items
   */
  render() {
    // Update which items should be visible
    this.updateVisibleItems();
    
    // Clear the current content
    this.virtualContent.innerHTML = '';
    
    // Render each visible item
    this.visibleItems.forEach((item, index) => {
      const actualIndex = this.startIndex + index;
      const itemElement = this.renderItem(item, actualIndex);
      
      // Position the item absolutely
      itemElement.style.position = 'absolute';
      itemElement.style.top = `${actualIndex * this.itemHeight}px`;
      itemElement.style.width = '100%';
      
      this.virtualContent.appendChild(itemElement);
    });
  }
  
  /**
   * Scroll to a specific item
   * @param {Number} index - Index of the item to scroll to
   */
  scrollToItem(index) {
    if (index >= 0 && index < this.items.length) {
      this.virtualScrollContainer.scrollTop = index * this.itemHeight;
    }
  }
  
  /**
   * Scroll to the top of the list
   */
  scrollToTop() {
    this.virtualScrollContainer.scrollTop = 0;
  }
  
  /**
   * Scroll to the bottom of the list
   */
  scrollToBottom() {
    this.virtualScrollContainer.scrollTop = this.items.length * this.itemHeight;
  }
  
  /**
   * Destroy the virtual list and clean up event listeners
   */
  destroy() {
    this.virtualScrollContainer.removeEventListener('scroll', this.handleScroll);
    window.removeEventListener('resize', this.handleResize);
    this.container.innerHTML = '';
  }
}

// Export for use in other files
window.VirtualNotificationList = VirtualNotificationList;

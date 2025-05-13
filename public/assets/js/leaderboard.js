/**
 * Leaderboard JavaScript Functionality
 * Handles the interactive elements of the leaderboard page
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize current date
    updateCurrentDate();
    
    // Initialize tabs
    initTabs();
    
    // Initialize search
    initSearch();
    
    // Initialize refresh button
    initRefreshButton();
    
    // Initialize social sharing
    initSocialSharing();
    
    // Initialize charts
    initCharts();
    
    // Initialize progress bars
    initProgressBars();
});

/**
 * Display current date in the header
 */
function updateCurrentDate() {
    const dateElement = document.getElementById('current-date');
    if (dateElement) {
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const date = new Date();
        dateElement.textContent = date.toLocaleDateString('id-ID', options);
    }
}

/**
 * Initialize the leaderboard tabs functionality
 */
function initTabs() {
    const tabs = document.querySelectorAll('.leaderboard-tab');
    const donorsSection = document.getElementById('leaderboard-donors');
    const communitiesSection = document.getElementById('leaderboard-communities');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            tabs.forEach(t => t.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Show the corresponding content
            const type = this.dataset.type;
            if (type === 'donors') {
                donorsSection.style.display = 'block';
                communitiesSection.style.display = 'none';
            } else {
                donorsSection.style.display = 'none';
                communitiesSection.style.display = 'block';
            }
        });
    });
}

/**
 * Initialize search functionality for leaderboard
 */
function initSearch() {
    const searchInput = document.getElementById('search-leaderboard');
    if (!searchInput) return;
    
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        const activeSectionId = document.querySelector('.leaderboard-tab.active').dataset.type === 'donors' 
            ? 'leaderboard-donors' 
            : 'leaderboard-communities';
        const items = document.querySelectorAll(`#${activeSectionId} .leaderboard-item`);
        
        items.forEach(item => {
            const name = item.dataset.name;
            if (name && name.includes(query)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
        
        // Check if no results are found
        const visibleItems = document.querySelectorAll(`#${activeSectionId} .leaderboard-item[style="display: flex"]`);
        const emptyStateElement = document.querySelector(`#${activeSectionId} .empty-search-results`);
        
        if (visibleItems.length === 0 && query !== '') {
            if (!emptyStateElement) {
                const emptyState = document.createElement('div');
                emptyState.className = 'empty-state empty-search-results';                emptyState.innerHTML = `
                    <div class="empty-state-icon">
                        <i class="fa fa-search"></i>
                    </div>
                    <div class="empty-state-text">Tidak ada hasil yang cocok dengan "${query}"</div>
                    <button class="empty-state-action" onclick="document.getElementById('search-leaderboard').value = ''; document.getElementById('search-leaderboard').dispatchEvent(new Event('input'));">
                        <i class="fa fa-times-circle"></i> Hapus Pencarian
                    </button>
                `;
                document.getElementById(activeSectionId).appendChild(emptyState);
            }
        } else {
            // Remove empty state if it exists
            if (emptyStateElement) {
                emptyStateElement.remove();
            }
        }
    });
}

/**
 * Initialize refresh button functionality
 */
function initRefreshButton() {
    const refreshBtn = document.getElementById('refresh-leaderboard');
    if (!refreshBtn) return;
    
    refreshBtn.addEventListener('click', function() {
        // Show loading spinner
        const activeSectionId = document.querySelector('.leaderboard-tab.active').dataset.type === 'donors' 
            ? 'donors-loading' 
            : 'communities-loading';
        const loadingElement = document.getElementById(activeSectionId);
        
        if (loadingElement) {
            loadingElement.style.display = 'flex';
            
            // Add rotating animation to button
            this.classList.add('rotating');
            
            // Simulate loading (in real app, this would be an AJAX call)
            setTimeout(() => {
                // Hide loading spinner
                loadingElement.style.display = 'none';
                // Remove rotating animation
                this.classList.remove('rotating');
                
                // Show success message
                showToast('Data berhasil diperbarui!', 'success');
            }, 1500);
        }
    });
}

/**
 * Initialize Chart.js charts
 */
function initCharts() {
    const chartCanvas = document.getElementById('contributorsChart');
    if (!chartCanvas) return;
    
    // Get top 5 donors and communities from the page
    const donorItems = document.querySelectorAll('#leaderboard-donors .leaderboard-item');
    const communityItems = document.querySelectorAll('#leaderboard-communities .leaderboard-item');
    
    // Extract data for top 5 donors
    const donorsData = {
        labels: [],
        data: [],
        colors: ['#4CAF50', '#66BB6A', '#81C784', '#A5D6A7', '#C8E6C9']
    };
    
    // Extract data for top 5 communities
    const communitiesData = {
        labels: [],
        data: [],
        colors: ['#2196F3', '#42A5F5', '#64B5F6', '#90CAF9', '#BBDEFB']
    };
    
    // Get data from top 5 donors
    Array.from(donorItems).slice(0, 5).forEach((item, index) => {
        const nameElement = item.querySelector('.leaderboard-name');
        const scoreElement = item.querySelector('.leaderboard-score');
        
        if (nameElement && scoreElement) {
            const name = nameElement.textContent.trim();
            const scoreText = scoreElement.textContent.trim();
            const score = parseInt(scoreText.replace(/[^\d]/g, ''));
            
            donorsData.labels.push(name);
            donorsData.data.push(score);
        }
    });
    
    // Get data from top 5 communities
    Array.from(communityItems).slice(0, 5).forEach((item, index) => {
        const nameElement = item.querySelector('.leaderboard-name');
        const scoreElement = item.querySelector('.leaderboard-score');
        
        if (nameElement && scoreElement) {
            const name = nameElement.textContent.trim();
            const scoreText = scoreElement.textContent.trim();
            const score = parseInt(scoreText.replace(/[^\d]/g, ''));
            
            communitiesData.labels.push(name);
            communitiesData.data.push(score);
        }
    });
    
    // Initialize chart with donors data first
    let contributorsChart = new Chart(chartCanvas, {
        type: 'bar',
        data: {
            labels: donorsData.labels,
            datasets: [{
                label: 'Jumlah Donasi (Kg)',
                data: donorsData.data,
                backgroundColor: donorsData.colors,
                borderColor: donorsData.colors.map(color => color),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.raw} Kg`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + ' Kg';
                        }
                    }
                }
            }
        }
    });
    
    // Add event listeners for chart toggle buttons
    const donorsBtn = document.getElementById('chart-donors-btn');
    const communitiesBtn = document.getElementById('chart-communities-btn');
    
    if (donorsBtn && communitiesBtn) {
        donorsBtn.addEventListener('click', function() {
            donorsBtn.classList.add('active');
            communitiesBtn.classList.remove('active');
            
            // Update chart with donors data
            contributorsChart.data.labels = donorsData.labels;
            contributorsChart.data.datasets[0].data = donorsData.data;
            contributorsChart.data.datasets[0].backgroundColor = donorsData.colors;
            contributorsChart.data.datasets[0].borderColor = donorsData.colors;
            contributorsChart.data.datasets[0].label = 'Jumlah Donasi (Kg)';
            contributorsChart.options.scales.y.ticks.callback = function(value) {
                return value + ' Kg';
            };
            contributorsChart.options.plugins.tooltip.callbacks.label = function(context) {
                return `${context.raw} Kg`;
            };
            contributorsChart.update();
        });
        
        communitiesBtn.addEventListener('click', function() {
            communitiesBtn.classList.add('active');
            donorsBtn.classList.remove('active');
            
            // Update chart with communities data
            contributorsChart.data.labels = communitiesData.labels;
            contributorsChart.data.datasets[0].data = communitiesData.data;
            contributorsChart.data.datasets[0].backgroundColor = communitiesData.colors;
            contributorsChart.data.datasets[0].borderColor = communitiesData.colors;
            contributorsChart.data.datasets[0].label = 'Jumlah Klaim';
            contributorsChart.options.scales.y.ticks.callback = function(value) {
                return value + ' Klaim';
            };
            contributorsChart.options.plugins.tooltip.callbacks.label = function(context) {
                return `${context.raw} Klaim`;
            };
            contributorsChart.update();
        });
    }
}

/**
 * Initialize progress bars with animation
 */
function initProgressBars() {
    const progressBars = document.querySelectorAll('.progress-bar');
    
    // Use Intersection Observer to trigger progress bar animation when visible
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const bar = entry.target;
                const width = bar.style.width;
                
                // Reset width
                bar.style.width = '0';
                
                // Animate to target width
                setTimeout(() => {
                    bar.style.width = width;
                }, 100);
                
                // Stop observing after animation
                observer.unobserve(bar);
            }
        });
    }, { threshold: 0.1 });
    
    // Observe each progress bar
    progressBars.forEach(bar => {
        observer.observe(bar);
    });
}

/**
 * Social sharing functionality
 */
function initSocialSharing() {
    // These functions are called directly from the HTML
}

/**
 * Share leaderboard on Facebook
 */
function shareOnFacebook() {
    const url = window.location.href;
    const shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
    window.open(shareUrl, '_blank', 'width=600,height=400');
}

/**
 * Share leaderboard on Twitter
 */
function shareOnTwitter() {
    const url = window.location.href;
    const text = 'Lihat peringkat kontributor terbaik di platform No Food Waste!';
    const shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`;
    window.open(shareUrl, '_blank', 'width=600,height=400');
}

/**
 * Share leaderboard on WhatsApp
 */
function shareOnWhatsApp() {
    const url = window.location.href;
    const text = 'Lihat peringkat kontributor terbaik di platform No Food Waste! 🏆';
    const shareUrl = `https://wa.me/?text=${encodeURIComponent(text + ' ' + url)}`;
    window.open(shareUrl, '_blank');
}

/**
 * Show a toast notification
 */
function showToast(message, type = 'info') {
    // Create toast element if it doesn't exist
    let toastContainer = document.getElementById('toast-container');
    
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.style.position = 'fixed';
        toastContainer.style.bottom = '20px';
        toastContainer.style.right = '20px';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }
    
    // Create toast
    const toast = document.createElement('div');
    toast.className = `toast toast-${type} animate__animated animate__fadeInUp`;
    toast.style.backgroundColor = type === 'success' ? '#4CAF50' : '#2196F3';
    toast.style.color = 'white';
    toast.style.padding = '10px 20px';
    toast.style.borderRadius = '4px';
    toast.style.marginTop = '10px';
    toast.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
    toast.style.display = 'flex';
    toast.style.alignItems = 'center';
      // Add icon based on type
    const icon = document.createElement('i');
    icon.className = type === 'success' ? 'fa fa-check-circle' : 'fa fa-info-circle';
    icon.style.marginRight = '10px';
    toast.appendChild(icon);
    
    // Add message
    const messageElement = document.createElement('span');
    messageElement.textContent = message;
    toast.appendChild(messageElement);
    
    // Add to container
    toastContainer.appendChild(toast);
      // Remove after 3 seconds
    setTimeout(() => {
        toast.classList.remove('animate__fadeInUp');
        toast.classList.add('animate__fadeOutDown');
        setTimeout(() => {
            toast.remove();
        }, 1000);
    }, 3000);
}

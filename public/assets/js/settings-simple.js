/**
 * Script untuk Halaman Settings dengan Desain Sederhana
 * NoFoodWaste - Simplified Settings Page
 */

document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi toggle Advanced Settings
    initAdvancedSettings();
    
    // Inisialisasi efek hover pada card
    initCardHover();
    
    // Inisialisasi pilihan frekuensi
    initFrequencyOptions();
});

/**
 * Inisialisasi toggle untuk menampilkan pengaturan lanjutan
 */
function initAdvancedSettings() {
    const advancedToggle = document.getElementById('toggleAdvanced');
    const advancedSettings = document.getElementById('advancedSettings');
    
    if (advancedToggle && advancedSettings) {
        advancedSettings.style.display = 'none';
        
        advancedToggle.addEventListener('click', function() {
            if (advancedSettings.style.display === 'none') {
                advancedSettings.style.display = 'flex';
                advancedToggle.innerHTML = '<i class="fa fa-chevron-up me-2"></i>Sembunyikan Pengaturan Lanjutan';
            } else {
                advancedSettings.style.display = 'none';
                advancedToggle.innerHTML = '<i class="fa fa-cog me-2"></i>Tampilkan Pengaturan Lanjutan';
            }
        });
    }
}

/**
 * Inisialisasi efek hover pada card
 */
function initCardHover() {
    const cards = document.querySelectorAll('.settings-card');
    
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 8px 24px rgba(0, 0, 0, 0.12)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.08)';
        });
    });
}

/**
 * Inisialisasi pilihan frekuensi notifikasi
 */
function initFrequencyOptions() {
    const frequencyCards = document.querySelectorAll('.frequency-option-card');
    
    frequencyCards.forEach(card => {
        const radioInput = card.querySelector('input[type="radio"]');
        
        card.addEventListener('click', function() {
            // Periksa radio button ketika card diklik
            radioInput.checked = true;
            
            // Trigger event change untuk update UI
            const event = new Event('change');
            radioInput.dispatchEvent(event);
        });
        
        // Update tampilan berdasarkan status checked
        radioInput.addEventListener('change', function() {
            frequencyCards.forEach(c => {
                const input = c.querySelector('input[type="radio"]');
                if (input.checked) {
                    c.classList.add('active');
                } else {
                    c.classList.remove('active');
                }
            });
        });
        
        // Inisialisasi tampilan awal
        if (radioInput.checked) {
            card.classList.add('active');
        }
    });
}

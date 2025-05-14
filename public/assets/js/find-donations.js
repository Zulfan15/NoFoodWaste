// --- PATCH: Update marker peta secara dinamis saat filter (tanpa reload) ---
function updateDonationMarkers(donations) {
    // Hapus marker lama
    donationMarkers.forEach(m => map.removeLayer(m));
    donationMarkers = [];
    // Tambah marker baru
    donations.forEach(function(donation) {
        if (donation.latitude && donation.longitude) {
            let marker = L.marker([donation.latitude, donation.longitude], {icon: foodIcon}).addTo(map);
            marker.bindPopup(donation.popupContent, {
                className: 'custom-marker-popup',
                maxWidth: 250
            });
            donationMarkers.push(marker);
        }
    });
    if (donationMarkers.length > 0) {
        const group = new L.featureGroup(donationMarkers);
        map.fitBounds(group.getBounds().pad(0.1));
    }
}

// Intercept filter form submit (desktop & mobile)
$('#filterForm, #mobileFilterForm').on('submit', function(e) {
    e.preventDefault();
    if (typeof showLoading === 'function') showLoading();
    $.get($(this).attr('action'), $(this).serialize() + '&ajax=1', function(response) {
        // response.donations = [{latitude, longitude, popupContent, ...}]
        if (response.donations) {
            updateDonationMarkers(response.donations);
        }
        // (Opsional) update grid donasi jika response.html tersedia
        if (response.html) {
            $('.donation-results').html(response.html);
        }
    }).always(function() {
        if (typeof hideLoading === 'function') hideLoading();
    });
});
// JS khusus halaman find-donations, dipindahkan dari Blade
$(document).ready(function() {
    // Initialize date picker
    flatpickr("#pickupDate, #mobilePickupDate", {
        enableTime: false,
        dateFormat: "Y-m-d",
        minDate: "today",
        allowInput: true
    });

    // Initialize Map
    let map = L.map('donationMap').setView([-6.200000, 106.816666], 13); // Jakarta coordinates
    let isFullMap = false;
    let userMarker = null;
    let donationMarkers = [];

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Custom icon for food donation markers
    const foodIcon = L.icon({
        iconUrl: foodMarkerUrl,
        iconSize: [32, 32],
        iconAnchor: [16, 32],
        popupAnchor: [0, -32]
    });

    // Add donation markers from database
    if (typeof donationMarkersData !== 'undefined') {
        donationMarkersData.forEach(function(donation) {
            if (donation.latitude && donation.longitude) {
                let marker = L.marker([donation.latitude, donation.longitude], {icon: foodIcon}).addTo(map);
                let popupContent = donation.popupContent;
                marker.bindPopup(popupContent, {
                    className: 'custom-marker-popup',
                    maxWidth: 250
                });
                donationMarkers.push(marker);
            }
        });
        if (donationMarkers.length > 0) {
            const group = new L.featureGroup(donationMarkers);
            map.fitBounds(group.getBounds().pad(0.1));
        }
    }

    // Center map on user's location
    $('#centerMap').click(function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                map.setView([lat, lng], 14);
                if (userMarker) {
                    userMarker.setLatLng([lat, lng]);
                } else {
                    const userIcon = L.icon({
                        iconUrl: userMarkerUrl,
                        iconSize: [32, 32],
                        iconAnchor: [16, 32]
                    });
                    userMarker = L.marker([lat, lng], {icon: userIcon}).addTo(map);
                    userMarker.bindPopup("Lokasi Anda").openPopup();
                }
                localStorage.setItem('userLat', lat);
                localStorage.setItem('userLng', lng);
                if (!$('#distanceMin').val() && !$('#distanceMax').val()) {
                    $.ajax({
                        url: getNearbyDonationsUrl,
                        method: 'GET',
                        data: filterAjaxData,
                        success: function(response) {
                            console.log('Nearby donations received');
                        },
                        error: function(xhr) {
                            console.error('Error fetching nearby donations');
                        }
                    });
                }
            }, function(error) {
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        alert("Izin lokasi ditolak. Silakan aktifkan akses lokasi di browser Anda.");
                        break;
                    case error.POSITION_UNAVAILABLE:
                        alert("Informasi lokasi tidak tersedia.");
                        break;
                    case error.TIMEOUT:
                        alert("Permintaan untuk mendapatkan lokasi pengguna habis waktu.");
                        break;
                    case error.UNKNOWN_ERROR:
                        alert("Terjadi kesalahan yang tidak diketahui.");
                        break;
                }
            });
        } else {
            alert("Geolocation tidak didukung oleh browser Anda.");
        }
    });

    $(window).on('load', function() {
        if (!localStorage.getItem('locationAsked')) {
            if (confirm("Apakah Anda ingin mengizinkan aplikasi untuk mendeteksi lokasi Anda untuk mendapatkan donasi terdekat?")) {
                $('#centerMap').click();
            }
            localStorage.setItem('locationAsked', 'true');
        }
    });

    $('#toggleFullMap').click(function() {
        const mapContainer = $('.search-map-container');
        const mapElement = $('#donationMap');
        if (isFullMap) {
            mapContainer.css({
                'position': 'relative',
                'z-index': '1',
                'width': '100%',
                'height': 'auto'
            });
            mapElement.css('height', '400px');
            $(this).html('<i class="fas fa-expand"></i>');
            isFullMap = false;
        } else {
            mapContainer.css({
                'position': 'fixed',
                'top': '0',
                'left': '0',
                'right': '0',
                'bottom': '0',
                'z-index': '1000',
                'width': '100%',
                'height': '100vh',
                'margin': '0',
                'border-radius': '0'
            });
            mapElement.css('height', 'calc(100vh - 70px)');
            $(this).html('<i class="fas fa-compress"></i>');
            isFullMap = true;
        }
        setTimeout(function() {
            map.invalidateSize();
        }, 100);
    });

    $('#showMobileFilters').click(function() {
        $('#mobileFiltersPanel').css('display', 'block');
    });
    $('#closeMobileFilters').click(function() {
        $('#mobileFiltersPanel').css('display', 'none');
    });
    $('#sortResults').change(function() {
        const sortValue = $(this).val();
        $('#sortInput').val(sortValue);
        $('#filterForm').submit();
    });
    $('#resetFilters, #resetMobileFilters').click(function(e) {
        e.preventDefault();
        window.location.href = findDonationsUrl;
    });
    $('#searchBtn').click(function() {
        $('#filterForm').submit();
    });
    $('#searchKeyword').keypress(function(e) {
        if (e.which === 13) {
            $('#searchBtn').click();
            return false;
        }
    });
    $('#categoryAll, #mobileCategoryAll').change();
});

<div class="map-popup">
    <div class="map-popup-image">
        <img src="{{ $donation->image ? asset('storage/' . $donation->image) : asset('assets/images/food-placeholder.jpg') }}" alt="{{ $donation->food_name }}" style="width:60px;height:60px;object-fit:cover;">
    </div>
    <div class="map-popup-content">
        <h5 class="map-popup-title" style="margin:0;font-size:1rem;">{{ $donation->food_name }}</h5>
        <div class="map-popup-meta" style="font-size:0.9rem;">
            <span><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($donation->expiration_date)->diffForHumans() }}</span><br>
            <span><i class="fas fa-box"></i> {{ $donation->quantity }} {{ $donation->unit ?? 'Porsi' }}</span>
        </div>
        <div class="map-popup-footer" style="font-size:0.9rem;">
            <div class="map-popup-distance">
                @if(isset($donation->distance))
                    {{ number_format($donation->distance, 1) }} km
                @else
                    Jarak tidak tersedia
                @endif
            </div>
            <a href="{{ route('donations.claim.form', $donation->donation_id) }}" class="map-popup-action btn btn-sm btn-primary mt-1">Ambil</a>
        </div>
    </div>
</div>

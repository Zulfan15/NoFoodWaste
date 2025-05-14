<div class="donation-grid">
@foreach($donations as $donation)
    <div class="donation-card">
        <div class="donation-image">
            @if($donation->image)
                <img src="{{ asset('storage/' . $donation->image) }}" alt="{{ $donation->food_name }}">
            @else
                <img src="{{ asset('assets/images/food-placeholder.jpg') }}" alt="{{ $donation->food_name }}">
            @endif
            <div class="donation-status available">Tersedia</div>
            <div class="donation-distance">
                <i class="fas fa-map-marker-alt"></i>
                @if(isset($donation->distance))
                    {{ number_format($donation->distance, 1) }} km
                @else
                    <span title="Jarak tidak tersedia">--</span>
                @endif
            </div>
        </div>
        <div class="donation-body">
            <h4 class="donation-title">{{ $donation->food_name }}</h4>
            <div class="donation-meta">
                <div class="donation-meta-item">
                    <i class="fas fa-calendar"></i>
                    @php
                        $expiryDate = \Carbon\Carbon::parse($donation->expiration_date);
                        $now = \Carbon\Carbon::now();
                        $diffHours = $now->diffInHours($expiryDate, false);
                        $diffDays = $now->diffInDays($expiryDate, false);
                    @endphp
                    @if($diffHours < 24)
                        Kedaluwarsa: {{ $diffHours }} Jam
                    @else
                        Kedaluwarsa: {{ $diffDays }} Hari
                    @endif
                </div>
                <div class="donation-meta-item">
                    <i class="fas fa-box"></i> {{ $donation->quantity }} {{ $donation->unit ?? 'Porsi' }}
                </div>
            </div>
            <p class="donation-description">
                {{ $donation->description ?? 'Tidak ada deskripsi' }}
            </p>
            <div class="donation-footer">
                <div class="donation-donor">
                    <img src="{{ asset($donation->donor->profile_image ?? 'assets/images/user-placeholder.jpg') }}" alt="Donor" class="donation-donor-avatar">
                    <span class="donation-donor-name">{{ $donation->donor->name }}</span>
                </div>
                <a href="{{ route('donations.claim.form', $donation->donation_id) }}" class="donation-action">Ambil</a>
            </div>
        </div>
    </div>
@endforeach
</div>

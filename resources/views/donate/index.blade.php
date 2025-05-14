@extends('layouts.admin.master')

@section('title', 'Donasi - No Food Waste')

@section('content')
    <section class="donate-section">
        <div class="donate-content">            <h1>Donasikan Makanan Anda</h1>            <p>Anda dapat membantu mengurangi pemborosan makanan dengan mendonasikan makanan kepada mereka yang membutuhkan.</p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form action="{{ url('/donate') }}" method="POST" enctype="multipart/form-data" id="donateForm">
                @csrf
                <div class="form-group">
                    <label for="food_name">Nama Makanan</label>
                    <input type="text" id="food_name" name="food_name" required class="form-control" maxlength="100">
                </div>
                <div class="form-group">
                    <label for="category">Kategori Makanan</label>
                    <select id="category" name="category" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="makanan-siap-saji">Makanan Siap Saji</option>
                        <option value="bahan-makanan">Bahan Makanan</option>
                        <option value="roti-kue">Roti & Kue</option>
                        <option value="buah-sayur">Buah & Sayur</option>
                        <option value="makanan-kaleng">Makanan Kaleng</option>
                        <option value="minuman">Minuman</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Jumlah</label>
                    <div class="input-group">
                        <input type="number" id="quantity" name="quantity" required class="form-control" min="1" max="10000">
                        <select id="unit" name="unit" class="form-select" style="max-width:120px;">
                            <option value="porsi">Porsi</option>
                            <option value="bungkus">Bungkus</option>
                            <option value="kg">Kg</option>
                            <option value="liter">Liter</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="expiry_date">Tanggal Kadaluarsa</label>
                    <input type="date" id="expiry_date" name="expiry_date" required class="form-control" min="{{ date('Y-m-d') }}">
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi Makanan</label>
                    <textarea id="description" name="description" class="form-control" rows="3" maxlength="255" placeholder="Deskripsi singkat makanan, kondisi, dsb."></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Foto Makanan (opsional)</label>
                    <input type="file" id="image" name="image" class="form-control" accept="image/*">
                </div>
                <div class="form-group mt-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Donasikan</button>
                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                </div>
            </form>
            <script>
            // Validasi client-side sederhana
            document.getElementById('donateForm').addEventListener('submit', function(e) {
                const qty = document.getElementById('quantity').value;
                const exp = document.getElementById('expiry_date').value;
                if (qty < 1) {
                    alert('Jumlah minimal 1.');
                    e.preventDefault();
                }
                if (exp && exp < '{{ date('Y-m-d') }}') {
                    alert('Tanggal kadaluarsa tidak boleh di masa lalu.');
                    e.preventDefault();
                }
            });
            </script>
        </div>
    </section>
@endsection

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

            <form action="{{ url('/donate') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="food_name">Nama Makanan</label>
                    <input type="text" id="food_name" name="food_name" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="quantity">Jumlah</label>
                    <input type="number" id="quantity" name="quantity" required class="form-control">
                </div>                <div class="form-group">
                    <label for="expiry_date">Tanggal Kadaluarsa</label>
                    <input type="date" id="expiry_date" name="expiry_date" required class="form-control">
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Donasikan</button>
                </div>
            </form>
        </div>
    </section>
@endsection

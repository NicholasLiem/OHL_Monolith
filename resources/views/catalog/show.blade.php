@extends('layout')

@section('content')
    <div class="container d-flex flex-column justify-content-center align-items-center">
        <h2 class="text-center mb-4">Product Detail</h2>

        @if ($barang)
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title">{{ $barang['nama'] }}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="card-text">Harga: {{ $barang['harga'] }}</p>
                            <p class="card-text">Stok: {{ $barang['stok'] }}</p>
                            <p class="card-test">Kode Barang: {{ $barang['kode'] }}</p>
                            <p class="card-test">Nama Perusahaan: {{ $barang['perusahaan_nama'] }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <form action="{{ route('order.show', ['id' => $barang['id']]) }}" method="GET">
                                <div class="input-group">
                                    <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="{{ $barang['stok'] }}" value="{{ old('quantity', 1) }}" required>
                                    <button type="submit" class="btn btn-primary">Order</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route('catalog.index') }}" class="btn btn-secondary mt-3">Back to Catalog</a>
        @else
            <p>Product not found.</p>
        @endif
    </div>
@endsection

@section('styles')
    <style>
        .container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            width: 400px;
        }
    </style>
@endsection
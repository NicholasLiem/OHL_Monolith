@extends('layout')

@section('content')
    <div class="container d-flex flex-column justify-content-center align-items-center">
        <h2 class="text-center mb-4">Order Detail</h2>

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
                            <p class="card-test">Kode Barang: {{ $barang['kode'] }}</p>
                            <p class="card-text">Kuantitas: {{ $quantity }}</p>
                            <p class="card-test">Total Harga: {{ $barang['total'] }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <form action="{{ route('order.purchase', ['id' => $barang['id']]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="username" value="{{ auth()->user()->username }}">
                                <input type="number" name="quantity" value="{{ $quantity }}" hidden>
                                <button type="submit" class="btn btn-primary">Purchase</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route('catalog.index') }}" class="btn btn-secondary mt-3">Back to Order</a>
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

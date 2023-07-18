@extends('layout')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="text-center">
            <h1 class="display-4 mt-5">Dashboard</h1>
            <p class="lead">All you need is right here</p>
            <div class="d-flex flex-row">
                <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-block mb-3 mx-2">Catalog</a>
                <a href="{{ route('order.history') }}" class="btn btn-primary btn-block mb-3 mx-2">Purchase History</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-danger btn-block mb-3 mx-2">Logout</button>
                </form>
            </div>
        </div>
    </div>
@endsection

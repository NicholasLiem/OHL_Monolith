@extends('layout')

@section('content')
    <div class="text-center">
        <h1 class="display-4 mt-5">Welcome to Tokekpedia</h1>
        <p class="lead">The best place for all your toking needs!</p>
        <div class="mt-5">
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg mr-3">Register</a>
            <a href="{{ route('login') }}" class="btn btn-secondary btn-lg">Login</a>
        </div>
    </div>
@endsection

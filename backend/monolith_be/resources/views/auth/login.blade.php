@extends('layout')

@section('content')
    <div class="container col-md-8 col-lg-6 col-xl-4 d-flex align-items-center justify-content-center vh-100 overflow-hidden">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header text-center">Login Form</div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="email">Email or Username:</label>
                                <input type="text" id="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>

                            <div class="form-group mt-3 text-center">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>

                            <p class="text-center mt-3 mb-0">Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layout')

@section('content')
    <div class="container col-md-8 col-lg-6 col-xl-4 d-flex align-items-center justify-content-center vh-100 overflow-hidden">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header text-center">Register Form</div>
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
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="first_name">First Name</label>
                                <input id="first_name" type="text" class="form-control" name="first_name" required autofocus>
                            </div>

                            <div class="form-group mb-3">
                                <label for="last_name">Last Name</label>
                                <input id="last_name" type="text" class="form-control" name="last_name" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="username">Username</label>
                                <input id="username" type="text" class="form-control" name="username" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control" name="email" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="password-confirm">Confirm Password</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>

                            <div class="form-group mt-3 text-center">
                                <button type="submit" class="btn btn-primary">Register</button>
                            </div>

                            <p class="text-center mt-3 mb-0">Already have an account? <a href="{{ route('login') }}">Login here</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layout')

@section('content')
<form action="/logout" method="post">
    @csrf
    <button type="submit">Logout</button>
</form>
@endsection
@extends('layout.app')

@section('title', 'Welcome to My Laravel App')

@section('nav')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container p-1">
        <h5>My Laravel App</h5>
        <div>
            <a href="/login" class="btn btn-primary btn-sm">Login</a>
            <a href="/register" class="btn btn-light btn-sm">Register</a>
        </div>
    </div>
</nav>
@endsection

@section('content')
    <div class="container">
        <div class="card mx-auto" style="width: 60%;margin-top: 100px">
        <div class="card-body">
            <h3 class="card-title mb-3">Welcome to my Laravel App</h3>
            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Curabitur venenatis massa in sapien fringilla hendrerit in vel risus. Sed quis lorem dolor. 
                Praesent nisi ex, tempus sit amet velit at, sagittis hendrerit arcu. Donec viverra, ligula sed dapibus tempus, risus lectus mollis erat, 
                eu ultricies sem tellus sit amet dui.
            </p>
            <a href="/login" class="btn btn-primary">Login</a>
        </div>
        </div>
    </div>
@endsection
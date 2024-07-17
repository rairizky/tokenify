@extends('layouts.auth')

@section('title', 'Login')

@section('content')
@if($errors->any())
<div class="alert alert-danger">
    <ul style="padding-left: 12px;">
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<form action="{{ route('auth.post_login') }}" method="POST">
    @csrf
    <div class="form-group">
        <label class="font-weight-semibold" for="email">Email</label>
        <div class="input-affix">
            <i class="prefix-icon anticon anticon-mail"></i>
            <input type="email" class="form-control" name="email" id="email" placeholder="Email">
        </div>
    </div>
    <div class="form-group">
        <label class="font-weight-semibold" for="password">Password</label>
        <div class="input-affix m-b-10">
            <i class="prefix-icon anticon anticon-lock"></i>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        </div>
    </div>
    <div class="form-group">
        <div class="d-flex align-items-center justify-content-between">
            <span class="font-size-13 text-muted">
                Don't have an account?
                <a class="small" href="{{ route('auth.register') }}"> Signup</a>
            </span>
            <button class="btn btn-primary">Login</button>
        </div>
    </div>
</form>
@endsection

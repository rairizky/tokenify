@extends('layouts.auth')

@section('title', 'Register')

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

<form action="{{ route('auth.post_register') }}" method="POST">
    @csrf
    <div class="form-group">
        <label class="font-weight-semibold" for="name">Name</label>
        <div class="input-affix">
            <i class="prefix-icon anticon anticon-user"></i>
            <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ old('name') }}">
        </div>
    </div>
    <div class="form-group">
        <label class="font-weight-semibold" for="phone">Phone Number</label>
        <div class="input-affix">
            <i class="prefix-icon anticon anticon-phone"></i>
            <input type="number" class="form-control" name="phone" id="phone" placeholder="Phone" value="{{ old('phone') }}">
        </div>
    </div>
    <div class="form-group">
        <label class="font-weight-semibold" for="email">Email</label>
        <div class="input-affix">
            <i class="prefix-icon anticon anticon-mail"></i>
            <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ old('email') }}">
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
                Already have an account?
                <a class="small" href="{{ route('auth.login') }}"> Login</a>
            </span>
            <button class="btn btn-primary">Register</button>
        </div>
    </div>
</form>
@endsection

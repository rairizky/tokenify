@extends('layouts.dashboard.dashboard')

@section('title', "Create Customer")

@section('content')
{{-- breadcrumb --}}
<div class="page-header">
    <h2 class="header-title">Create Customer</h2>
    <div class="header-sub-title">
        <nav class="breadcrumb breadcrumb-dash">
            <a class="breadcrumb-item" href="{{ route('dashboard.customer.data.index') }}">Data</a>
            <span class="breadcrumb-item active">Create</span>
        </nav>
    </div>
</div>

{{-- content --}}
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Create Customer</h4>
        </div>
      <div class="m-t-25">
        {{-- errors alert --}}
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="padding-left: 12px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('dashboard.customer.data.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label for="number">Number</label>
                <input type="text" name="number" class="form-control" id="number" placeholder="Number" value="{{ old('number') }}">
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" class="form-control" id="address" placeholder="Address" value="{{ old('address') }}">
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
        </form>
      </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('.select2').select2();
</script>
@endsection

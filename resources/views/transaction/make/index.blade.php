@extends('layouts.dashboard.dashboard')

@section('title', "Make Transaction")

@section('content')
{{-- breadcrumb --}}
<div class="page-header">
    <h2 class="header-title">Transaction</h2>
    <div class="header-sub-title">
        <nav class="breadcrumb breadcrumb-dash">
            <span class="breadcrumb-item active">Make</span>
        </nav>
    </div>
</div>

{{-- content --}}
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Make Transaction</h4>
        </div>
      <div class="m-t-25">
        {{-- alert success --}}
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error_query'))
        <div class="alert alert-danger">
            {{ session('error_query') }}
        </div>
        @endif

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

        {{-- code here --}}
        <form action="{{ route('dashboard.transaction.make.store') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="number">Number</label>
                        <input type="text" name="number" class="form-control" id="number" placeholder="Number" value="{{ old('number') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product">Product</label>
                        <div>
                            <select class="select2" name="product">
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} - Rp {{ number_format($product->price) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Pay</button>
            </div>
        </form>
      </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('#data-table').DataTable();
</script>

<script>
    $('.select2').select2();

    $('.select2').on('select2:select', function (e) {
        var selectedData = e.params.data;
        console.log('Selected data:', selectedData);
        // You can add your custom event handling code here
    });
</script>
@endsection

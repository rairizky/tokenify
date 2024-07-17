@extends('layouts.dashboard.dashboard')

@section('title', "Transaction")

@section('content')
{{-- breadcrumb --}}
<div class="page-header">
    <h2 class="header-title">Transaction</h2>
    <div class="header-sub-title">
        <nav class="breadcrumb breadcrumb-dash">
            <span class="breadcrumb-item active">Data</span>
        </nav>
    </div>
</div>

{{-- content --}}
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Transaction</h4>
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
        <table id="data-table" class="table">
            <thead>
                <th>Name</th>
                <th>Product</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date Paid</th>
                <th>Token Code</th>
            </thead>
            <tbody>
                @foreach ($histories as $history)
                    <tr>
                        <td>{{ $history->user->name }}</td>
                        <td>{{ $history->product->name }}</td>
                        <td>Rp {{ number_format($history->total) }}</td>
                        <td>
                            @if ($history->status === "Paid")
                                <span class="badge badge-pill badge-success">Paid</span>
                            @else
                                <span class="badge badge-pill badge-warning">Unpaid</span>
                            @endif
                        </td>
                        <td>
                            @if ($history->date_paid)
                                {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $history->date_paid)->format('d-m-Y') }}
                            @else
                               {{ '-' }}
                            @endif
                        </td>
                        <td>
                            @if ($history->token_code)
                                {{ $history->token_code }}
                            @else
                               {{ '-' }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('#data-table').DataTable();
</script>
@endsection

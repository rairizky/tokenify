@extends('layouts.dashboard.dashboard')

@section('title', "History Transaction")

@section('content')
{{-- breadcrumb --}}
<div class="page-header">
    <h2 class="header-title">Transaction</h2>
    <div class="header-sub-title">
        <nav class="breadcrumb breadcrumb-dash">
            <span class="breadcrumb-item active">History</span>
        </nav>
    </div>
</div>

{{-- content --}}
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h4>History Transaction</h4>
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
                <th>Product</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date Paid</th>
                <th>Token Code</th>
                <th style="width: 200px !important;">Action</th>
            </thead>
            <tbody>
                @foreach ($histories as $history)
                    <tr>
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
                        <td>
                            @if ($history->status !== "Paid")
                                <div class="d-flex justify-content-center" style="gap: 5px">
                                    <button class="btn btn-icon btn-warning btn-rounded" onclick="CheckPayment('{{ $history->code }}')">
                                        <i class="anticon anticon-dollar"></i>
                                    </button>
                                </div>
                            @else
                                -
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

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    function CheckPayment(code) {
        snap.pay(code, {
            // Optional
            onSuccess: function(result) {
                /* You may add your own js here, this is just example */
                // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `http://localhost:8000/dashboard/transaction/history/${code}`,
                    type: 'post'
                }).done((data) => {
                    window.location.reload();
                }).fail((err) => {
                    console.error(err);
                })
            },
            // Optional
            onPending: function(result) {
                /* You may add your own js here, this is just example */
                // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                console.log(result)
            },
            // Optional
            onError: function(result) {
                /* You may add your own js here, this is just example */
                // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                console.log(result)
            }
        });
    }
</script>
@endsection

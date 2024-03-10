@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success mb-3" role="alert">{{ session('success') }}</div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pembayaran</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-12">
                <div class="container mt-5 mb-5 d-flex justify-content-center">
                    <div class="card p-5">
                        <div>
                            <h4 class="heading">Proses Pembayaran</h4>
                            <p class="text">Anda dapat memilih metode pembayaran yang sesuai dengan anda , proses masa
                                berlaku
                                pembayaran adalah 1 X 24 Jam</p>
                        </div>
                        <div class="pricing p-3 rounded mt-4 d-flex justify-content-between">
                            <div class="images d-flex flex-row align-items-center">
                                <div class="d-flex flex-column"> <span class="business">
                                        <h3><b>Total Pembayaran</b></h3>
                                    </span> </div>
                            </div>
                            <div class="d-flex flex-row align-items-center"> <sup class="font-weight-bold">Rp</sup>
                                <span
                                    class="amount ml-1 mr-1">{{ number_format($pesanan->jumlah_harga, 2, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="mt-3"> <button class="btn btn-primary btn-block payment-button" id="pay-button">Bayar
                                Sekarang <i class="fa fa-long-arrow-right"></i></button> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            // SnapToken acquired from previous step
            snap.pay('{{ $transaction->snap_token }}', {
                // Optional
                onSuccess: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    window.location.href = '{{ route('success', $transaction->id) }}';
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        };
    </script>
@endsection

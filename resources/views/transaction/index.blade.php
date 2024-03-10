@extends('layouts.app')

@section('title', 'Checkout Berhasil')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="container">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pembayaran</li>
                    </ol>
                </nav>
            </div>
            <div class="card">
                <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                    <h1 class="text-success">Pembayaran Berhasil</h1>
                    <p class="text-success">Terima kasih telah melakukan pembayaran</p>
                    {{-- <a href="{{ route('transactions') }}" class="btn btn-primary mt-3">Lihat Transaksi</a> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

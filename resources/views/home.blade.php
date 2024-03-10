@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @foreach ($barangs as $barang)
                <div class="col-md-3">
                    <div class="card" style="">
                        <img src="{{url('uploads/'.$barang->gambar)}}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{$barang->nama_barang}}</h5>
                            <p class="card-text"><b>Harga : Rp {{number_format($barang->harga,2,',','.')}}</b></p>
                            <p class="card-text">
                                <strong>Stok : {{$barang->stok}}</strong>
                                <hr>
                                <strong>Keterangan : {{$barang->keterangan}}</strong>
                            </p>
                            <a href="{{url('pesan/'.$barang->id)}}" class="btn btn-flat btn-primary"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Pesan</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection





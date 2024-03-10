@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-4">
                <a href="{{ url('home') }}" class="btn btn-primary">Kembali</a>
            </div>
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Produk</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ url('uploads/' . $barang->gambar) }}" alt="{{ $barang->nama_barang }}"
                                    width="100%">
                            </div>
                            <div class="col-md-6 mt-5">
                                <h3 class="mb-6">{{ $barang->nama_barang }}</h3>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Harga</td>
                                            <td>: </td>
                                            <td>Rp {{ number_format($barang->harga, 2, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Stock</td>
                                            <td>: </td>
                                            <td>{{ $barang->stok }}</td>
                                        </tr>
                                        <tr>
                                            <td>Deskripsi</td>
                                            <td>: </td>
                                            <td>{{ $barang->keterangan }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah Pesan</td>
                                            <td>: </td>
                                            <td>
                                                <form action="{{ url('pesan') . '/' . $barang->id }}" method="POST">
                                                    @csrf
                                                    <input type="number" name="jumlah_pesan" class="form-control"
                                                        min="1" required value="1">
                                                    <button type="submit" class="btn btn-primary mt-2"><i
                                                            class="fa fa-shopping-cart" aria-hidden="true"></i>
                                                        Pesan</button>
                                                </form>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @if (Session::has('success'))
        <script>
            alert('{{ Session::get('success') }}');
        </script>
    @endif
@endsection

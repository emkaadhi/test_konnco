<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    public function _construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        $barang = Barang::where('id', $id)->first();
        return view('pesan.index', compact('barang'));
    }

    public function pesan(Request $request, $id)
    {

        $barang = Barang::where('id', $id)->first();
        $tanggal = Carbon::now();

        if ($request->jumlah_pesan > $barang->stok) {
            return redirect('/pesan/' . $id)->with('error', 'Jumlah melebihi stok');
        }

        $cek_pesanan = Pesanan::where('user_id', auth()->user()->id)->where('status', 0)->first();

        if (empty($cek_pesanan)) {

            $pesanan = new Pesanan;
            $pesanan->user_id = auth()->user()->id;
            $pesanan->tanggal = $tanggal;
            $pesanan->status = 0;
            $pesanan->jumlah_harga = 0;
            $pesanan->save();
        }

        $pesanan_baru = Pesanan::where('user_id', auth()->user()->id)->where('status', 0)->first();

        $cek_pesanan_detail = PesananDetail::where('pesanan_id', $pesanan_baru->id)->where('barang_id', $barang->id)->first();

        if (empty($cek_pesanan_detail)) {
            $pesanan_detail = new PesananDetail;
            $pesanan_detail->pesanan_id = $pesanan_baru->id;
            $pesanan_detail->barang_id = $barang->id;
            $pesanan_detail->jumlah = $request->jumlah_pesan;
            $pesanan_detail->jumlah_harga = $request->jumlah_pesan * $barang->harga;
            $pesanan_detail->save();
        } else {
            $pesanan_detail = PesananDetail::where('pesanan_id', $pesanan_baru->id)->where('barang_id', $barang->id)->first();
            $pesanan_detail->jumlah = $pesanan_detail->jumlah + $request->jumlah_pesan;
            $pesanan_detail->jumlah_harga = $pesanan_detail->jumlah * $barang->harga;
            $pesanan_detail->update();
        }

        $pesanan = Pesanan::where('user_id', auth()->user()->id)->where('status', 0)->first();

        $pesanan->jumlah_harga = $pesanan->jumlah_harga + ($request->jumlah_pesan * $barang->harga);
        $pesanan->update();

        return redirect('/home')->with('success', 'Barang sukses masuk keranjang , Silakan cek keranjang belanja anda !');
    }
}

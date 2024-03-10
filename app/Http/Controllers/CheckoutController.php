<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::where('user_id', auth()->user()->id)->where('status', 0)->first();
        $pesanan_details = [];
        if (!empty($pesanan)) {
            $pesanan_details = PesananDetail::where('pesanan_id', $pesanan->id)->get();
        }
        $pesanan_ok = Pesanan::where('user_id', auth()->user()->id)->where('status', 1)->latest()->first();
        return view('checkout.index', compact('pesanan', 'pesanan_details', 'pesanan_ok'));
    }

    public function delete($id)
    {
        $pesanan_detail = PesananDetail::where('id', $id)->first();
        $pesanan = Pesanan::where('id', $pesanan_detail->pesanan_id)->first();
        $pesanan->jumlah_harga = $pesanan->jumlah_harga - $pesanan_detail->jumlah_harga;
        $pesanan->update();
        $pesanan_detail->delete();
        return redirect('/checkout');
    }

    public function konfirmasi()
    {
        $pesanan = Pesanan::where('user_id', auth()->user()->id)->where('status', 0)->first();
        $pesanan->status = 1;
        $pesanan->update();

        $pesanan_ok = Pesanan::where('user_id', auth()->user()->id)->where('status', 1)->latest()->first();

        if (!empty($pesanan_ok)) {
            $transaction = Transaction::create([
                'user_id' => Auth::user()->id,
                'pesanan_id' => $pesanan_ok->id,
                'price' => $pesanan_ok->jumlah_harga,
                'status' => 'pending',
            ]);
        }
        
        $items = PesananDetail::where('pesanan_id', $pesanan_ok->id)->get();

        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $transaction['price'],
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $transaction->snap_token = $snapToken;
        $transaction->save();

        return redirect()->route('payment', $transaction->id);
    }

    public function payment(Transaction $transaction)
    {
        $pesanan = Pesanan::where('id',$transaction->pesanan_id)->first();
        return view('checkout.payment',compact('pesanan','transaction'));
    }

    public function success(Transaction $transaction)
    {
        $transaction->status = 'success';
        $transaction->update();
        return view('transaction.index');
    }
}

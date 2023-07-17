<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Transaction;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{
    public function show(Request $request, $id)
    {
        $quantity = $request->input('quantity');
        $response = Http::get('localhost:3000/barang/'.$id);

        if ($response->successful()) {
            $barang = $response->json()['data'];
            $barang['total'] = $barang['harga'] * $quantity;
            return view('order.show', compact('barang', 'quantity'));
        } else {
            return back()->withError('Gagal mengambil data barang');
        }
    }


    public function purchase(Request $request, $id)
    {
        $quantity = $request->input('quantity');
        
        $loginResponse = Http::post('localhost:3000/login', [
            'username' => 'admin',
            'password' => 'admin'
        ]);

        // dd($loginResponse->json());

        if ($loginResponse->successful()) {
            $token = $loginResponse->json()['data']['token'];
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->put('localhost:3000/barang/'.$id, [
                'stok' => $request->input('stok') - $quantity
            ]);

            // dd($response->json());
            
            if ($response->successful()) {
                $this->createTransaction($request);
                return redirect()->route('dashboard')->withSuccess('Berhasil melakukan pembelian');
            } else {
                return back()->withError('Gagal melakukan pembelian');
            }
        } else {
            return back()->withError('Gagal melakukan login');
        }
    }

    public function createTransaction(Request $request)
    {
        $transaction = Transaction::create([
            'username' => $request->username,
            'product_code' => $request->product_code,
            'purchase_date' => $request->purchase_date,
            'quantity' => $request->quantity
        ]);
    }
}

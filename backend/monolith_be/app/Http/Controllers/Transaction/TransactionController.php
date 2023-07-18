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

        $barangResponse = Http::get('http://localhost:3000/barang/'.$id);

        if ($barangResponse->successful()) {
            $barangData = $barangResponse->json()['data'];

            $nama = $barangData['nama'];
            $harga = $barangData['harga'];
            $stok = $barangData['stok'];
            $kode = $barangData['kode'];

            $newStok = $stok - $quantity;

            $loginResponse = Http::post('http://localhost:3000/login', [
                'username' => 'admin',
                'password' => 'admin'
            ]);

            if ($loginResponse->successful()) {
                $token = $loginResponse->json()['data']['token'];

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                ])->put('http://localhost:3000/barang/'.$id, [
                    'nama' => $nama,
                    'harga' => $harga,
                    'stok' => $newStok,
                    'kode' => $kode,
                ]);
                
                if ($response->successful()) {
                    $this->createTransaction(
                        $request->username,
                        $kode,
                        date('Y-m-d H:i:s'),
                        $quantity,
                        $harga * $quantity
                    );
                    return redirect()->route('dashboard')->withSuccess('Berhasil melakukan pembelian');
                } else {
                    return back()->withError('Gagal melakukan pembelian');
                }
            } else {
                return back()->withError('Gagal melakukan login');
            }
        }
    }


    public function createTransaction($username, $product_code, $purchase_date, $quantity, $total_price)
    {
        $transaction = Transaction::create([
            'username' => $username,
            'product_code' => $product_code,
            'purchase_date' => $purchase_date,
            'quantity' => $quantity,
            'total_price' => $total_price
        ]);
    }
}

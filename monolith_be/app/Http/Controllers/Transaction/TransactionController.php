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

        try {
            $barangResponse = Http::get('http://localhost:3000/barang/'.$id);

            if ($barangResponse->successful()) {
                $barangData = $barangResponse->json()['data'];

                $nama = $barangData['nama'];
                $harga = $barangData['harga'];
                $stok = $barangData['stok'];
                $perusahaan_id = $barangData['perusahaan_id'];
                $kode = $barangData['kode'];

                if ($quantity > $stok) {
                    return back()->withError('Gagal melakukan pembelian. Stok tidak mencukupi.');
                }

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
                        'perusahaan_id' => $perusahaan_id,
                        'kode' => $kode,
                    ]);

                    if ($response->successful()) {
                        $this->createTransaction(
                            $request->username,
                            $nama,
                            $kode,
                            date('Y-m-d H:i:s'),
                            $quantity,
                            $harga * $quantity
                        );
                        return redirect()->route('dashboard')->withSuccess('Berhasil melakukan pembelian');
                    }
                }
            }

            return back()->withError('Gagal melakukan pembelian');
        } catch (\Exception $e) {
            return back()->withError('Terjadi kesalahan saat melakukan pembelian: '.$e->getMessage());
        }
    }


    public function createTransaction($username, $product_name, $product_code, $purchase_date, $quantity, $total_price)
    {
        $transaction = Transaction::create([
            'username' => $username,
            'product_name' => $product_name,
            'product_code' => $product_code,
            'purchase_date' => $purchase_date,
            'quantity' => $quantity,
            'total_price' => $total_price
        ]);
    }

    public function history()
    {
        $transactions = Transaction::where('username', Session::get('username'))->paginate(10);
        return view('order.history', compact('transactions'));
    }
}

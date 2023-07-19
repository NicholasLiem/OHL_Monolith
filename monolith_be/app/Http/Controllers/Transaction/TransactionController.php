<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Transaction;
use Illuminate\Support\Facades\Session;
use App\Helpers\ResponseUtils;

class TransactionController extends Controller
{
    public function show(Request $request, $id)
    {
        $api_base_url = env('API_BASE_URL');
        $quantity = $request->input('quantity');
        $response = Http::get($api_base_url . '/barang/'.$id);

        if ($response->successful()) {
            $barang = $response->json()['data'];
            $barang['total'] = $barang['harga'] * $quantity;
            ResponseUtils::flashSuccess('Berhasil mengambil detail pembelian barang dengan id: '. $id . '.');
            return view('order.show', compact('barang', 'quantity'));
        } else {
            return ResponseUtils::flashError('Gagal mengambil data barang.');
        }
    }


    public function purchase(Request $request, $id)
    {
        $api_base_url = env('API_BASE_URL');
        $quantity = $request->input('quantity');

        try {
            $barangResponse = Http::get($api_base_url . '/barang/'.$id);

            if ($barangResponse->successful()) {
                $barangData = $barangResponse->json()['data'];

                $nama = $barangData['nama'];
                $harga = $barangData['harga'];
                $stok = $barangData['stok'];
                $perusahaan_id = $barangData['perusahaan_id'];
                $kode = $barangData['kode'];

                if ($quantity > $stok) {
                    return ResponseUtils::flashError('Stok barang tidak mencukupi');
                }

                $newStok = $stok - $quantity;

                $loginResponse = Http::post($api_base_url . '/login', [
                    'username' => env('API_USERNAME'),
                    'password' => env('API_PASSWORD')
                ]);

                if ($loginResponse->successful()) {
                    $token = $loginResponse->json()['data']['token'];

                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $token,
                    ])->put($api_base_url .'/barang/'.$id, [
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

                        ResponseUtils::flashSuccess('Berhasil melakukan pembelian barang dengan kode: ' . $kode . ' sebanyak '. $quantity . ' buah.');
                        return redirect()->route('dashboard');
                    }
                }
            }

            ResponseUtils::flashError('Gagal melakukan pembelian');
        } catch (Exception $e) {
            ResponseUtils::flashError('Gagal melakukan pembelian');
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
        try {
            $transactions = Transaction::where('username', auth()->user()['username'])->paginate(10);
        } catch (Exception $e){
            ResponseUtils::flashError('Gagal mengambil data transaksi, mungkin user tidak ada.');
        }

        ResponseUtils::flashSuccess('Berhasil mengambil data transaksi dari user: '.auth()->user()['username'].'.');
        return view('order.history', compact('transactions'));
    }
}

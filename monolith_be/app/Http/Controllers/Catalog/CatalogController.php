<?php


namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use App\Helpers\ResponseUtils;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $api_base_url = env('API_BASE_URL');
        $query = $request->input('q');

        $response = Http::get($api_base_url . '/barang', [
            'q' => $query,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $items = collect($data['data']);

            if ($items->isEmpty()) {
                return ResponseUtils::flashError('Tidak ada barang yang ditemukan.');
            }

            $perPage = 9; // Number of items per page
            $currentPage = Paginator::resolveCurrentPage('page');

            $catalog = new LengthAwarePaginator(
                $items->forPage($currentPage, $perPage),
                $items->count(),
                $perPage,
                $currentPage,
                [
                    'path' => Paginator::resolveCurrentPath(),
                ]
            );

            ResponseUtils::flashSuccess('Berhasil mengambil data barang.');
            return view('catalog.index', compact('catalog'));
        } else {
            return ResponseUtils::flashError('Gagal mengambil data barang.');
        }
    }


    public function show($id)
    {
        $api_base_url = env('API_BASE_URL');
        $response = Http::get($api_base_url . '/barang/' .$id);
        
        if ($response->successful()) {
            $barang = $response->json()['data'];

            $perusahaanId = $barang['perusahaan_id'];
            $perusahaanResponse = Http::get($api_base_url .'/perusahaan/'.$perusahaanId);

            if ($perusahaanResponse->successful()) {

                $perusahaan = $perusahaanResponse->json()['data'];
                $perusahaanNama = $perusahaan['nama'];
                $barang['perusahaan_nama'] = $perusahaanNama;

            } else {
                return ResponseUtils::flashError('Gagal mengambil data perusahaan.');
            }
            
            ResponseUtils::flashSuccess('Berhasil mengambil data barang dengan id: '. $barang['id']);
            return view('catalog.show', compact('barang'));
        } else {
            return ResponseUtils::flashError('Gagal mengambil data barang.');
        }
    }

}

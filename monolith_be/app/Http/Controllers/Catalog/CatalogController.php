<?php


namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;


class CatalogController extends Controller
{
    public function index()
    {
        $response = Http::get('localhost:3000/barang');
        
        if ($response->successful()) {
            $data = $response->json();
            $items = collect($data['data']);

            $perPage = 9; // Number of items per page
            $currentPage = Paginator::resolveCurrentPage('page');

            $lastPage = ceil($items->count() / $perPage);
            if ($currentPage > $lastPage) {
                return redirect()->route('catalog.index', ['page' => $lastPage]);
            }

            $currentItems = $items->slice(($currentPage - 1) * $perPage, $perPage);
            $catalog = new LengthAwarePaginator($currentItems, $items->count(), $perPage, $currentPage, [
                'path' => Paginator::resolveCurrentPath(),
            ]);

            return view('catalog.index', compact('catalog'));
        } else {
            return back()->withError('Gagal mengambil data katalog.');
        }
    }


    public function show($id)
    {
        $response = Http::get('localhost:3000/barang/'.$id);
        
        if ($response->successful()) {
            $barang = $response->json()['data'];

            $perusahaanId = $barang['perusahaan_id'];
            $perusahaanResponse = Http::get('localhost:3000/perusahaan/'.$perusahaanId);

            if ($perusahaanResponse->successful()) {

                $perusahaan = $perusahaanResponse->json()['data'];
                $perusahaanNama = $perusahaan['nama'];
                $barang['perusahaan_nama'] = $perusahaanNama;

            } else {
                return back()->withError('Gagal mengambil data perusahaan.');
            }

            return view('catalog.show', compact('barang'));
        } else {
            return back()->withError('Gagal mengambil detail barang.');
        }
    }

}

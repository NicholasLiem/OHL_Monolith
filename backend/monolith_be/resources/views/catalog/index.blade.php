@extends('layout')

@section('content')
    <div class="container">
        <h2 class="text-center mb-4 mt-4">Catalog</h2>
        <div class="row">
            @foreach ($catalog as $item)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item['nama'] }}</h5>
                            <p class="card-text">Harga: {{ $item['harga'] }}</p>
                            <p class="card-text">Stok: {{ $item['stok'] }}</p>
                            <a href="{{ route('catalogue.show', ['id' => $item['id']]) }}" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row mt-4">
            <div class="col d-flex justify-content-center">
                @if ($catalog->currentPage() > 1)
                    <a href="{{ $catalog->previousPageUrl() }}" class="btn btn-primary mx-1">Previous</a>
                @endif

                <div class="btn-group" role="group" aria-label="Page navigation">
                    @php
                        $currentPage = $catalog->currentPage();
                        $lastPage = $catalog->lastPage();
                        $maxPages = 5;
                        $halfMaxPages = floor($maxPages / 2);
                        $startPage = max($currentPage - $halfMaxPages, 1);
                        $endPage = min($currentPage + $halfMaxPages, $lastPage);
                        $ellipsisStart = ($startPage > 1);
                        $ellipsisEnd = ($endPage < $lastPage);
                    @endphp

                    @if ($ellipsisStart)
                        <a class="btn btn-primary disabled mx-1">...</a>
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <a href="{{ $catalog->url($i) }}" class="btn btn-primary{{ $i === $currentPage ? ' active' : '' }}">{{ $i }}</a>
                    @endfor

                    @if ($ellipsisEnd)
                        <a class="btn btn-primary disabled mx-1">...</a>
                    @endif
                </div>

                @if ($catalog->hasMorePages())
                    <a href="{{ $catalog->nextPageUrl() }}" class="btn btn-primary mx-1">Next</a>
                @endif
            </div>
        </div>
    </div>
@endsection
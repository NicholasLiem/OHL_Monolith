@extends('layout')

@section('content')
    <div class="container">
        <div class="row justify-content-between align-items-center mb-4">
            <div class="col-md-6">
                <h2 class="text-center mb-0">Catalog</h2>
            </div>
            <div class="col-md-6">
                <form action="{{ route('catalog.index') }}" method="GET" class="form-inline my-2 my-md-0">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search by name or code" value="{{ request()->q }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            @foreach ($catalog as $item)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item['nama'] }}</h5>
                            <p class="card-text">Harga: {{ $item['harga'] }}</p>
                            <p class="card-text">Stok: {{ $item['stok'] }}</p>
                            <a href="{{ route('catalog.show', ['id' => $item['id']]) }}" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row mt-2">
            <div class="col d-flex justify-content-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item{{ $catalog->onFirstPage() ? ' disabled' : '' }}">
                            <a class="page-link" href="{{ $catalog->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

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
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif

                        @for ($i = $startPage; $i <= $endPage; $i++)
                            <li class="page-item{{ $i === $currentPage ? ' active' : '' }}"><a class="page-link" href="{{ $catalog->url($i) }}">{{ $i }}</a></li>
                        @endfor

                        @if ($ellipsisEnd)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif

                        <li class="page-item{{ $catalog->hasMorePages() ? '' : ' disabled' }}">
                            <a class="page-link" href="{{ $catalog->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .container {
            padding-top: 50px;
        }

        .table {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        th, td {
            text-align: center;
        }

        /* Compact Pagination Style */
        .pagination {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .page-item {
            margin: 0 3px;
        }

        .page-item.disabled .page-link {
            opacity: 0.6;
            pointer-events: none;
        }

        .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }

        .page-link {
            color: #007bff;
            border: 1px solid #007bff;
            padding: 5px 10px;
            border-radius: 3px;
            text-decoration: none;
            transition: background-color 0.2s;
        }

        .page-link:hover {
            background-color: #f2f2f2;
        }
    </style>
@endsection

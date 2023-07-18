@extends('layout')

@section('content')
    <div class="container">
        <h2 class="text-center mb-4">Transaction History</h2>

        @if ($transactions->isEmpty())
            <p>No transactions found.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Product Name</th>
                            <th>Product Code</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->product_name }}</td>
                                <td>{{ $transaction->product_code }}</td>
                                <td>{{ $transaction->quantity }}</td>
                                <td>{{ $transaction->total_price }}</td>
                                <td>{{ $transaction->purchase_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row mt-4">
                <div class="col d-flex justify-content-center">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li class="page-item{{ $transactions->onFirstPage() ? ' disabled' : '' }}">
                                <a class="page-link" href="{{ $transactions->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>

                            @php
                                $currentPage = $transactions->currentPage();
                                $lastPage = $transactions->lastPage();
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
                                <li class="page-item{{ $i === $currentPage ? ' active' : '' }}"><a class="page-link" href="{{ $transactions->url($i) }}">{{ $i }}</a></li>
                            @endfor

                            @if ($ellipsisEnd)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif

                            <li class="page-item{{ $transactions->hasMorePages() ? '' : ' disabled' }}">
                                <a class="page-link" href="{{ $transactions->nextPageUrl() }}" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        @endif
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

<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function showTransaction()
    {
        return view('transaction');
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

<?php

namespace App\Http\Controllers;

use App\Models\Prod;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function api()
    {
        $data = Transaction::with(['transactionDetails.product', 'user', 'payment'])->get();
        return $data;
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request->product_id as $product_id) {
            Transaction::create([
                'product_id' => $product_id,
                'qty' => 1
            ]);
        }
        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        $data = TransactionDetail::with('product')
            ->where('transaction_id', $transaction->id)
            ->get();

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Transaction::select('payments.id', 'metode', 'number_card', 'code_ref')
            ->join('payments', 'payments.id', '=', 'transactions.payment_id')
            ->where('transactions.id', $id)
            ->get();
        return response()->json($data);;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransactionRequest  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Payment::findOrFail($id);

        $data->update([
            'metode' => $request->metode,
            'number_card' => $request->number_card,
            'code_ref' => $request->code_ref
        ]);

        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaksi = Transaction::findOrFail($id);

        // Hapus terlebih dahulu pembayaran yang terkait
        $transaksi->payment()->delete();
        $transaksi->transactionDetails()->delete();

        // Setelah itu baru hapus transaksi itu sendiri
        $transaksi->delete();
        return true;
    }
}

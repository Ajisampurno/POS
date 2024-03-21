<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Ramsey\Uuid\Uuid;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;




class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function api()
    {
        $data = Payment::all();

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
     * @param  \App\Http\Requests\StorePaymentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = 1;

        $tanggal = date('Ymd');
        $uuid = Uuid::uuid4();
        $paymentId = 'PAY-' . $userId . '-' . $tanggal . '-' . $uuid;
        $transactionId = 'TRX-' . $userId . '-' . $tanggal . '-' . $uuid;

        $request->validate([
            'metode' => 'nullable',
            'number_card' => 'nullable',
            'code_ref' => 'nullable',
        ]);

        DB::beginTransaction(); // Mulai transaksi database

        try {
            Transaction::create([
                'id' => $transactionId,
                'user_id' => $userId,
                'payment_id' => $paymentId,
                'date' => date('Ymd'),
                'status' => 'sold',
            ]);

            Payment::create([
                'id' => $paymentId,
                'metode' => $request->metode,
                'number_card' => $request->number_card,
                'code_ref' => $request->code_ref
            ]);

            $carts = Cart::select('product_id', 'carts.qty', 'products.price')
                ->join('products', 'products.id', '=', 'carts.product_id')
                ->get();

            foreach ($carts as $detail) {
                TransactionDetail::create([
                    'transaction_id' => $transactionId,
                    'product_id' => $detail->product_id,
                    'qty' => $detail->qty,
                    'price' => $detail->price
                ]);
            }
            DB::commit();
            Cart::truncate();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        $data = Payment::select('*')
            ->join('transactions', 'transactions.payment_id', '=', 'payments.id')
            ->join('products', 'products.id', '=', 'product_id')
            ->where('payments.id', $payment->id)
            ->get();
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePaymentRequest  $request
     * @param  \App\Models\Payment  $payment
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
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return true;
    }
}

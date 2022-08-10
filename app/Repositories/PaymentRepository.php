<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository
{
    public function store($request, $transaction, string $status)
    {
        if(!empty($request->downPayment)){
            $price = $request->downPayment;
        } else {
            $price = $request->payment;
        }
        $payment = Payment::create([
            'user_id' => Auth()->user()->id,
            'transaction_id' => $transaction->id,
            'tpt' => $request->tpt,
            'total_price' => $request->total_price,
            'ts' => $request->ts,
            'tva' => $request->tva,
            'tva' => $request->tva,
            'price' => $price,
            'status' => $status
        ]);

        return $payment;
    }
}

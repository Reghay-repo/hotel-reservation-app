<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\Room;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionRepository
{
    public function store($request, Customer $customer, Room $room)
    {
        $transaction = Transaction::create([
            'user_id' => auth()->user()->id,
            'customer_id' => $customer->id,
            'adult_num' => $request->adults_num,
            'kids_num' => $request->kids_num,
            'room_id' => $room->id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'status' => 'Reservation'
        ]);

        return $transaction;
    }

    public function getTransaction($request)
    {
        $transactions = Transaction::with('user', 'room', 'customer')->where('check_out', '>=', Carbon::now());

        if (!empty($request->search)) {
            $transactions = $transactions->where('id', '=', $request->search);
        }

        $transactions = $transactions->orderBy('check_out', 'ASC')->orderBy('id', 'DESC')->paginate(20);
        $transactions->appends($request->all());

        return $transactions;
    }

    public function getTransactionExpired($request)
    {
        $transactionsExpired = Transaction::with('user', 'room', 'customer')->where('check_out', '<', Carbon::now());

        if (!empty($request->search)) {
            $transactionsExpired = $transactionsExpired->where('id', '=', $request->search);
        }

        $transactionsExpired = $transactionsExpired->orderBy('check_out', 'ASC')->paginate(20);
        $transactionsExpired->appends($request->all());

        return $transactionsExpired;
    }





   public  function get_monthly_results($request) {

        $num_pax = 0;
        $num_adults = 0;
        $num_kids = 0;
        $total = 0;
        $tpt = 0;
        $ts = 0;
        $tva = 0;
        $total_ttc = 0;
     
        
        $transactions_in_certan_month_and_year = Transaction::query()
        ->whereMonth('check_in', $request->month)
        ->whereYear('check_in', $request->year)
        ->with('payment')
        ->orderBy('id', 'DESC')->get();

        foreach ($transactions_in_certan_month_and_year as $transaction) {
            $num_adults += $transaction->adult_num;
            $num_kids += $transaction->kids_num;
            $payment = $transaction->payment[0];
            $total +=  $payment->price;
            $tpt +=  $payment->tpt;
            $ts +=  $payment->ts;
            $tva +=  $payment->tva;
            $total_ttc +=  $payment->total_price;
        }

       
        return [
            'number_of_adults' => $num_adults,
            'number_of_kids' => $num_kids,
            'number_of_people' => $num_kids + $num_adults,
            'total_ht' => $total,
            'tpt' => $tpt,
            'ts' => $ts,
            'total_ttc' => $total_ttc,
        ];
    }


    public function getData($year,$month) 
    {
            $num_pax = 0;
            $num_adults = 0;
            $num_kids = 0;
            $total = 0;
            $tpt = 0;
            $ts = 0;
            $tva = 0;
            $total_ttc = 0;
            
            $transactions_in_certan_month_and_year = Transaction::query()
            ->whereMonth('check_in', $month)
            ->whereYear('check_in', $year)
            ->with('payment')
            ->orderBy('id', 'DESC')->get();
    
            foreach ($transactions_in_certan_month_and_year as $transaction) {
                $num_adults += $transaction->adult_num;
                $num_kids += $transaction->kids_num;
                $payment = $transaction->payment[0];
                $total +=  $payment->price;
                $tpt +=  $payment->tpt;
                $ts +=  $payment->ts;
                $tva +=  $payment->tva;
                $total_ttc +=  $payment->total_price;
            }
    
           
            return [
                'number_of_adults' => $num_adults,
                'number_of_kids' => $num_kids,
                'number_of_people' => $num_kids + $num_adults,
                'total_ht' => $total,
                'tpt' => $tpt,
                'ts' => $ts,
                'tva' => $tva,
                'total_ttc' => $total_ttc,
            ];
    }

   
}

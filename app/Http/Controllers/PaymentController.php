<?php

namespace App\Http\Controllers;

use \PDF;
use NumberFormatter;
use App\Helpers\Helper;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\PaymentRepository;

class PaymentController extends Controller
{
    public $paymentRepository;

    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function index()
    {
        $payments = Payment::orderBy('id','DESC')->paginate(5);
        return view('payment.index', compact('payments'));
    }

    public function create(Transaction $transaction)
    {
        return view('transaction.payment.create', compact('transaction'));
    }

    public function store(Transaction $transaction, Request $request)
    {
        $insufficient = $transaction->getTTTC() - $transaction->getTotalPayment();
        $request->validate([
            'payment' => 'required|numeric|lte:' . $insufficient
        ]);

        $this->paymentRepository->store($request, $transaction, 'Payment');

        return redirect()->route('transaction.index')->with('success', 'Transaction room ' . $transaction->room->number . ' success, ' . Helper::convertToRupiah($request->payment) . ' paid');
    }

    public function invoice(Payment $payment)
    {
        $fileName = 'TRANSACTON_ID_' . $payment->transaction_id . '_FACTURE_PAIMENT.pdf' ;
        $pdf = PDF::loadView('payment.invoice', ['payment' => $payment])->setOptions(['defaultFont' => 'sans-serif']);

        return view('payment.invoice', ['payment' => $payment]);
        
    }
    public function download(Payment $payment)
    {
        $fileName = 'TRANSACTON_ID_' . $payment->transaction_id . '_FACTURE_PAIMENT.pdf' ;

        $pdf = PDF::loadView('payment.invoice', ['payment' => $payment])->setOptions(['defaultFont' => 'sans-serif']);

        // return view('payment.invoice', ['payment' => $payment]);
        return  $pdf->download($fileName);

        
        
    }
}

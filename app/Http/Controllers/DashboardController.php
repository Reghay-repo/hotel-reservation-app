<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Repositories\TransactionRepository;

class DashboardController extends Controller
{

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function index(Request $request)
    {
        
        $transactions = Transaction::with('user', 'room', 'customer')
            ->where([['check_in', '<=', Carbon::now()], ['check_out', '>=', Carbon::now()]])
            ->orderBy('check_out', 'ASC')
            ->orderBy('id', 'DESC')->get();
            
            
            
            $months = [
                '01' =>$this->transactionRepository->getData(Carbon::now()->format('Y'),'01'), 
                '02' =>$this->transactionRepository->getData(Carbon::now()->format('Y'),'02'), 
                '03' =>$this->transactionRepository->getData(Carbon::now()->format('Y'),'03'), 
                '04' =>$this->transactionRepository->getData(Carbon::now()->format('Y'),'04'), 
                '05' =>$this->transactionRepository->getData(Carbon::now()->format('Y'),'05'), 
                '06' =>$this->transactionRepository->getData(Carbon::now()->format('Y'),'06'), 
                '07' =>$this->transactionRepository->getData(Carbon::now()->format('Y'),'07'), 
                '08' =>$this->transactionRepository->getData(Carbon::now()->format('Y'),'08'), 
                '09' =>$this->transactionRepository->getData(Carbon::now()->format('Y'),'09'), 
                '10' =>$this->transactionRepository->getData(Carbon::now()->format('Y'),'10'), 
                '11' =>$this->transactionRepository->getData(Carbon::now()->format('Y'),'11'), 
                '12' =>$this->transactionRepository->getData(Carbon::now()->format('Y'),'12'), 
            ];
            
            $tri = [

            ];
            $year = 0;
            
            if(!empty($request->year)) {
                $year = $request->year;
                $months = [
                    '01' =>$this->transactionRepository->getData($request->year,'01'), 
                    '02' =>$this->transactionRepository->getData($request->year,'02'), 
                    '03' =>$this->transactionRepository->getData($request->year,'03'), 
                    '04' =>$this->transactionRepository->getData($request->year,'04'), 
                    '05' =>$this->transactionRepository->getData($request->year,'05'), 
                    '06' =>$this->transactionRepository->getData($request->year,'06'), 
                    '07' =>$this->transactionRepository->getData($request->year,'07'), 
                    '08' =>$this->transactionRepository->getData($request->year,'08'), 
                    '09' =>$this->transactionRepository->getData($request->year,'09'), 
                    '10' =>$this->transactionRepository->getData($request->year,'10'), 
                    '11' =>$this->transactionRepository->getData($request->year,'11'), 
                    '12' =>$this->transactionRepository->getData($request->year,'12'), 
                ];
            }
            

           
              
        


        return view('dashboard.index', compact('transactions','months','year'));
    }
}

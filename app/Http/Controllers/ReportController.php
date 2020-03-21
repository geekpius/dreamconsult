<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\AdminModel\Payment;
use App\AdminModel\Service;
use Illuminate\Http\Request;
use App\Mail\DebtorRemindMail;
use NumberToWords\NumberToWords;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('verify-admin');
        $this->middleware('auth:admin');
    }

    
    
    public function transaction()
    {
        $data['page_title'] = 'Transactions Report';
        return view('admin.transactions', $data);
    }

    public function allTransaction()
    {
        $data['payments'] = Payment::orderBy('id','DESC')->get();
        return view('admin.all-transactions', $data)->render();
    }

    public function todayTransaction()
    {
        $data['payments'] = Payment::whereDate('created_at','=', Carbon::today())->orderBy('id','DESC')->get();
        return view('admin.today-transactions', $data)->render();
    }

    public function weekTransaction()
    {
        $start = Carbon::now()->startOfWeek()->format('Y-m-d');   
        $end = Carbon::now()->endOfWeek()->format('Y-m-d');   
        $data['payments'] = Payment::whereDate('created_at','>=', $start)->whereDate('created_at','<=',$end)->orderBy('id','DESC')->get();
        return view('admin.week-transactions', $data)->render();
    }

    public function monthTransaction()
    {
        $data['payments'] = Payment::whereMonth('created_at','>=', Carbon::now()->month)->orderBy('id','DESC')->get();
        return view('admin.month-transactions', $data)->render();
    }

    public function yearTransaction()
    {
        $data['payments'] = Payment::whereYear('created_at','>=', Carbon::now()->year)->orderBy('id','DESC')->get();
        return view('admin.year-transactions', $data)->render();
    }

    public function singleTransaction(Request $request)
    {
        $data['payments'] = Payment::whereDate('created_at','=', $request->date)->orderBy('id','DESC')->get();
        $data['date'] = $request->date;
        return view('admin.single-transactions', $data)->render();
    }

    public function rangeTransaction(Request $request)
    {
        $data['payments'] = Payment::whereDate('created_at','>=', $request->first_date)->whereDate('created_at','<=',$request->end_date)->orderBy('id','DESC')->get();
        $data['start'] = $request->first_date;
        $data['end'] = $request->end_date;
        return view('admin.range-transactions', $data)->render();
    }

    public function debtor()
    {
        $data['page_title'] = 'Debtors Report';
        $data['debtors'] = User::where('balance','>', 0)->whereComplete(true)->get();
        return view('admin.debtors', $data);
    }

    public function fullPayer()
    {
        $data['page_title'] = 'Full Payers Report';
        $data['debtors'] = User::where('balance','<=', 0)->whereComplete(true)->get();
        return view('admin.full-payer', $data);
    }

    public function sendDebtorReminder(Request $request)
    {
        try{
            $count =0;
            foreach($request->ids as $id){
                $debtor = User::findOrFail($id);
                if(!empty($debtor->email)){
                    $data['first_name'] = $debtor->first_name;
                    $data['debt'] = $debtor->balance;
                    $data['services'] = Service::whereUser_id($debtor->id)->get();
                    Mail::to($debtor->email)->send(new DebtorRemindMail($data));
                    $count +=1;
                }
            }
            $message = $count.' clients with email contact are have received debt notice successful';
        }catch(\Exception $e){
            $message = 'error';
        }

        return $message;
        
    }

    public function serviceTransaction()
    {
        $data['page_title'] = 'Service Transactions Report';
        return view('admin.service-transactions', $data);
    }

    public function serviceAllTransaction()
    {
        $data['payments'] = Payment::orderBy('id','DESC')->get();
        return view('admin.service-all-transactions', $data)->render();
    }

    public function serviceTodayTransaction()
    {
        $data['payments'] = Payment::whereDate('created_at','=', Carbon::today())->orderBy('id','DESC')->get();
        return view('admin.service-today-transactions', $data)->render();
    }

    public function serviceWeekTransaction()
    {
        $start = Carbon::now()->startOfWeek()->format('Y-m-d');   
        $end = Carbon::now()->endOfWeek()->format('Y-m-d');   
        $data['payments'] = Payment::whereDate('created_at','>=', $start)->whereDate('created_at','<=',$end)->orderBy('id','DESC')->get();
        return view('admin.service-week-transactions', $data)->render();
    }

    public function serviceMonthTransaction()
    {
        $data['payments'] = Payment::whereMonth('created_at','>=', Carbon::now()->month)->orderBy('id','DESC')->get();
        return view('admin.service-month-transactions', $data)->render();
    }

    public function serviceYearTransaction()
    {
        $data['payments'] = Payment::whereYear('created_at','>=', Carbon::now()->year)->orderBy('id','DESC')->get();
        return view('admin.service-year-transactions', $data)->render();
    }


    public function serviceSingleTransaction(Request $request)
    {
        $data['payments'] = Payment::whereDate('created_at','=', $request->date)->orderBy('id','DESC')->get();
        $data['date'] = $request->date;
        return view('admin.service-single-transactions', $data)->render();
    }

    public function serviceRangeTransaction(Request $request)
    {
        $data['payments'] = Payment::whereDate('created_at','>=', $request->first_date)->whereDate('created_at','<=',$request->end_date)->orderBy('id','DESC')->get();
        $data['start'] = $request->first_date;
        $data['end'] = $request->end_date;
        return view('admin.service-range-transactions', $data)->render();
    }

    public function cashFlow()
    {
        $data['page_title'] = 'Cash Flow Report';
        return view('admin.cash-flow', $data);
    }

    public function allCashFlow()
    {
        $data['payments'] = Payment::orderBy('id','DESC')->get();
        return view('admin.all-cash-flow', $data)->render();
    }

    public function rangeCashFlow(Request $request)
    {
        $data['payments'] = Payment::whereDate('created_at','>=', $request->first_date)->whereDate('created_at','<=',$request->end_date)->orderBy('id','DESC')->get();
        $data['start'] = $request->first_date;
        $data['end'] = $request->end_date;
        return view('admin.range-cash-flow', $data)->render();
    }

    
    


}

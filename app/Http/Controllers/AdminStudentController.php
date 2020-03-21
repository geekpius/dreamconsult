<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use App\AdminModel\Log;
use App\AdminModel\Price;
use App\Mail\ReceiptMail;
use App\AdminModel\Branch;
use App\AdminModel\Course;
use App\Mail\RegisterMail;
use App\Mail\TransferMail;
use App\AdminModel\Payment;
use App\AdminModel\Profile;
use App\AdminModel\Service;
use App\AdminModel\Visitor;
use Illuminate\Support\Str;
use App\AdminModel\Discount;
use Illuminate\Http\Request;
use App\AdminModel\Emergency;
use NumberToWords\NumberToWords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ReceiveRequest;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\VisitorRequest;
use Illuminate\Support\Facades\Session;

class AdminStudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('verify-admin');
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function visitor()
    {
        $data['page_title'] = 'Old Visitors'; 
        if(Auth::user()->branch=='HEAD OFFICE'){
            $data['visitors'] = Visitor::all();
        }else{
            $data['visitors'] = Visitor::whereBranch(Auth::user()->branch)->get();
        }
        return view('admin.view-visitors', $data);
    }

    public function newVisitor()
    {
        $data['page_title'] = 'Add New Visitor'; 
        $data['services'] = Course::all();
        $data['branches'] = Branch::all();
        return view('admin.visitors', $data);
    }

    public function storeVisitor(VisitorRequest $request)
    {
        try{
            DB::beginTransaction();
            $visitor = new Visitor;
            $visitor->first_name=$request->first_name;
            $visitor->last_name=$request->last_name;
            $visitor->email=$request->email;
            $visitor->phone=$request->phone_number;
            $visitor->created_at=$request->registration;
            $service = implode(',',$request->services);
            $visitor->service=$service;            
            $visitor->additional=$request->additional_info;   
            $branch = (Auth::user()->branch=='HEAD OFFICE')? $request->branch:Auth::user()->branch;         
            $visitor->branch=$branch;            
            $visitor->save();
            if(Auth::user()->role!='developer'){
                $this->logActivity(Auth::user()->name, Auth::user()->branch, "Saved new visitor - ". $visitor->first_name." ".$visitor->last_name);
            }
            DB::commit();
            $message = 'Visitor added successful';
            $title = 'Added';
            $type = 'success';
        }catch(\Exception $e){
            DB::rollBack();
            $message = 'Something went wrong';
            $title = 'Opps';
            $type = 'error';
        }

        session()->flash('message', $message);
        Session::flash('type', $type);
        Session::flash('title', $title);
        return redirect()->back();
    
    }

    public function updateVisitor(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone_number' => 'required|numeric',
        ]);

        if ($validator->fails()){
            $message = 'Something went wrong with your inputs. Try again.';
            $title = 'Opps';
            $type = 'error';
        }
        else{  
            try{
                DB::beginTransaction();
                $visitor = Visitor::findorFail($request->visitor_id);
                $visitor->first_name = $request->first_name;
                $visitor->last_name = $request->last_name;
                $visitor->phone = $request->phone_number;
                $visitor->update();
                if(Auth::user()->role!='developer'){
                    $this->logActivity(Auth::user()->name, Auth::user()->branch, "Updated visitor to ". $visitor->first_name." ".$visitor->last_name." - phone: ".$visitor->phone);
                }
                DB::commit();
                $message = 'Visitor updated successful';
                $title = 'Updated';
                $type = 'success';
            }catch(\Exception $e){
                DB::rollBack();
                $message = 'Something went wrong';
                $title = 'Opps';
                $type = 'error';
            }
        }

        session()->flash('message', $message);
        Session::flash('type', $type);
        Session::flash('title', $title);
        return redirect()->back();
    }

    public function destroyVisitor(Visitor $visitor)
    {
        if(Auth::user()->role!='developer'){
            $this->logActivity(Auth::user()->name, Auth::user()->branch, "Deleted visitor to ". $visitor->first_name." ".$visitor->last_name);
        }
        $visitor->delete();
        session()->flash('message', 'Visitor deleted successful');
        Session::flash('type', 'success');
        Session::flash('title', 'Deleted');
        return redirect()->back();
    }
    

    public function student()
    {
        $data['page_title'] = 'View Clients'; 
        if(Auth::user()->branch=='HEAD OFFICE'){
            $data['users'] = User::whereComplete(true)->get();
        }
        else{
            $data['users'] = User::whereBranch(Auth::user()->branch)->whereComplete(true)->get();
        }
        $data['services'] = Course::all();
        $data['branches'] = Branch::all();
        return view('admin.view-students', $data);
    }

    public function createStudent()
    {
        $data['page_title'] = 'Register New Client'; 
        $data['services'] = Course::all();
        $data['branches'] = Branch::all();
        return view('admin.students', $data);
    }

    public function storeStudent(StudentRequest $request)
    {
        $branch = (Auth::user()->branch=='HEAD OFFICE')? $request->branch:Auth::user()->branch; 
        $sid = gmdate('ymdHis');
        $pay_amount = 0; $c_p = 0;
        foreach($request->services as $service){
            $payable = Price::whereBranch($branch)->whereCourse($service)->first(); 
            if(empty($payable)){
                $c_p+=1;
            }
            else{
                $pay_amount+=$payable->amount;
            }
        }
            
        if($c_p!=0){
            $message = $c_p.' of the service price is not set';
            $title = 'Opps';
            $type = 'error';
        }
        else{
            try{
                DB::beginTransaction();
                $student = new User;
                $student->student_id=$sid;
                $student->first_name=$request->first_name;
                $student->last_name=$request->last_name;
                $student->email=$request->email;
                $student->phone=$request->phone;
                $student->password=Hash::make(Str::random());
                $student->branch=$branch; 
                $student->payable=$pay_amount;                    
                $student->balance=($pay_amount);         
                $student->discount_check= (empty($request->discount))? true:false;
                $student->created_at=$request->registration;
                $student->save();

                //profile 
                $profile = new Profile;
                $profile->user_id = $student->id;
                $profile->dob = $request->dob;
                $profile->pob = $request->pob;
                $profile->passport = $request->passport_number;
                $profile->passport_expiry = $request->passport_expiry;
                $profile->profession = $request->profession;
                $profile->language = $request->language;
                $profile->country = $request->country;
                $profile->street = $request->street_address;
                $profile->city = $request->city;
                $profile->save();
                
                //services
                foreach($request->services as $service){
                    $payable = Price::whereBranch($branch)->whereCourse($service)->first(); 
                    $ser = new Service;
                    $ser->user_id = $student->id;
                    $ser->type = $service;
                    $ser->payable = $payable->amount;
                    $ser->save();
                }

                //save discount if discount
                if(!empty($request->discount)){
                    $discount = new Discount;
                    $discount->user_id = $student->id;
                    $discount->service = $request->discount_service;
                    $discount->amount = $request->discount;
                    $discount->save();
                }

                //emergency
                $emerge = new Emergency;
                $emerge->user_id = $student->id;
                $emerge->name = $request->emergency;
                $emerge->phone = $request->emergency_phone;
                $emerge->address = $request->emergency_address;
                $emerge->save();
                if(!empty($student->email)){
                    $data['first_name'] = $student->first_name;
                    $data['services'] = Service::whereUser_id($student->id)->get();
                    Mail::to($student->email)->send(new RegisterMail($data));
                }

                if(Auth::user()->role!='developer'){
                    $this->logActivity(Auth::user()->name, Auth::user()->branch, "Saved new client - ID: ". $student->student_id." FirstName: ".$student->first_name);
                }
                DB::commit();
                $message = 'Student registered successful';
                $title = 'Registered';
                $type = 'success';
                return redirect()->route('admin.viewstudent.checkreg', $student->id);
            }catch(\Exception $e){
                DB::rollBack();
                $message = 'Something went wrong';
                $title = 'Opps';
                $type = 'error';
            }
        }

        session()->flash('message', $message);
        Session::flash('type', $type);
        Session::flash('title', $title);
        return redirect()->back();
    
    }
    
    public function checkRegistration(User $user)
    {
        $data['page_title'] = 'Checking '.$user->first_name.' Registration'; 
        $data['user'] = $user;
        return view('admin.check-registered-client', $data);
    }

    public function receivePayment(User $user)
    {
        $data['page_title'] = 'Receive '.$user->first_name.' Payment'; 
        $data['services'] = Service::whereUser_id($user->id)->get();
        $data['user'] = $user;
        $data['discount'] = Discount::whereUser_id($user->id)->whereStatus(false)->orderBy('id','DESC')->first();
        return view('admin.receives', $data);
    }

    public function submitPayment(ReceiveRequest $request)
    {
        $disc = Discount::whereUser_id($request->user_id)->whereStatus(false)->orderBy('id','DESC')->first();
        $service = Service::whereUser_id($request->user_id)->whereType($request->service)->first();

        if(($service->payable-$service->paid)<$request->amount){
            $message = 'Amount received exceed amount owed for '.$request->service;
            $title = 'Exceed';
            $type = 'error';
        }
        else{
            if(!empty($disc)){
                if($disc->service==$request->service){
                    if(($service->payable-$service->paid)<($request->amount+$request->discount)){
                        $message = 'Amount received with discount exceed amount owed for '.$request->service;
                        $title = 'Exceed';
                        $type = 'error';
                    }
                    else{
                        try{
                            DB::beginTransaction();
                            $pay = new Payment;
                            $pay->user_id = $request->user_id;
                            $pay->receipt_no = $this->findReceipt();
                            $pay->service=$request->service;
                            $pay->mode=$request->mode;
                            $pay->payable=$service->payable-$service->paid;
                            $pay->paid=($request->amount+$request->discount);
                            $pay->owe=($service->payable-$service->paid) - ($request->amount+$request->discount);
                            $pay->save();

                            //update service
                            $service->paid = $service->paid + ($request->amount+$request->discount);
                            $service->update();

                            //update discount
                            $disc->status = true;
                            $disc->payment_id = $pay->id;
                            $disc->update();

                            //update user
                            $user = User::findorFail($request->user_id);
                            $user->paid= $user->paid + ($request->amount+$request->discount);
                            $user->balance= $user->balance - ($request->amount+$request->discount);
                            $user->complete= true;
                            $user->update();
                            //send email
                            $numberToWords = new NumberToWords();
                            $numberTransformer = $numberToWords->getNumberTransformer('en');

                            if(!empty($user->email)){
                                $data['first_name'] = $user->first_name;
                                $data['payment'] = $pay;
                                $data['discount'] = $request->discount;
                                $data['words'] = $numberTransformer->toWords($pay->paid); 
                                Mail::to($user->email)->send(new ReceiptMail($data));
                            }
                            if(Auth::user()->role!='developer'){
                                $this->logActivity(Auth::user()->name, Auth::user()->branch, "Recieved payment from with discount ". $user->student_id." FirstName: ".$user->first_name." - paid: GHs".number_format($pay->paid,2)." for ".$request->service);
                            }
                            DB::commit();
                            $message = 'Amount received successful';
                            $title = 'Received';
                            $type = 'success';
                            return redirect()->route('admin.receivepay.receipt', $pay->id);
                        }catch(\Exception $e){
                            DB::rollBack();
                            $message = 'Something went wrong';
                            $title = 'Opps';
                            $type = 'error';
                        }
                    }
                }else{
                    try{
                        DB::beginTransaction();
                        $pay = new Payment;
                        $pay->user_id = $request->user_id;
                        $pay->receipt_no = $this->findReceipt();
                        $pay->service=$request->service;
                        $pay->mode=$request->mode;
                        $pay->payable=$service->payable-$service->paid;
                        $pay->paid=$request->amount;
                        $pay->owe=($service->payable-$service->paid) - $request->amount;
                        $pay->save();

                        //update service
                        $service->paid = $service->paid + $request->amount;
                        $service->update();

                        //update user
                        $user = User::findorFail($request->user_id);
                        $user->paid= $user->paid + $request->amount;
                        $user->balance= $user->balance - $request->amount;
                        $user->complete= true;
                        $user->update();
                        //send email
                        $numberToWords = new NumberToWords();
                        $numberTransformer = $numberToWords->getNumberTransformer('en');

                        if(!empty($user->email)){
                            $data['first_name'] = $user->first_name;
                            $data['payment'] = $pay;
                            $data['words'] = $numberTransformer->toWords($pay->paid); 
                            $data['discount'] = 0;
                            Mail::to($user->email)->send(new ReceiptMail($data));
                        }
                        if(Auth::user()->role!='developer'){
                            $this->logActivity(Auth::user()->name, Auth::user()->branch, "Recieved payment from ". $user->student_id." FirstName: ".$user->first_name." - paid: GHs".number_format($pay->paid,2)." for ".$request->service);
                        }
                        DB::commit();
                        $message = 'Amount received successful';
                        $title = 'Received';
                        $type = 'success';
                        return redirect()->route('admin.receivepay.receipt', $pay->id);
                    }catch(\Exception $e){
                        DB::rollBack();
                        $message = 'Something went wrong';
                        $title = 'Opps';
                        $type = 'error';
                    }
                }
            }
            else{
                try{
                    DB::beginTransaction();
                    $pay = new Payment;
                    $pay->user_id = $request->user_id;
                    $pay->receipt_no = $this->findReceipt();
                    $pay->service=$request->service;
                    $pay->mode=$request->mode;
                    $pay->payable=$service->payable-$service->paid;
                    $pay->paid=$request->amount;
                    $pay->owe=($service->payable-$service->paid) - $request->amount;
                    $pay->save();

                    //update service
                    $service->paid = $service->paid + $request->amount;
                    $service->update();

                    //update user
                    $user = User::findorFail($request->user_id);
                    $user->paid= $user->paid + $request->amount;
                    $user->balance= $user->balance - $request->amount;
                    $user->complete= true;
                    $user->update();
                    //send email
                    $numberToWords = new NumberToWords();
                    $numberTransformer = $numberToWords->getNumberTransformer('en');

                    if(!empty($user->email)){
                        $data['first_name'] = $user->first_name;
                        $data['payment'] = $pay;
                        $data['discount'] = 0;
                        $data['words'] = $numberTransformer->toWords($pay->paid); 
                        Mail::to($user->email)->send(new ReceiptMail($data));
                    }
                    if(Auth::user()->role!='developer'){
                        $this->logActivity(Auth::user()->name, Auth::user()->branch, "Recieved payment from ". $user->student_id." FirstName: ".$user->first_name." - paid: GHs".number_format($pay->paid,2)." for ".$request->service);
                    }
                    DB::commit();
                    $message = 'Amount received successful';
                    $title = 'Received';
                    $type = 'success';
                    return redirect()->route('admin.receivepay.receipt', $pay->id);
                }catch(\Exception $e){
                    DB::rollBack();
                    $message = 'Something went wrong';
                    $title = 'Opps';
                    $type = 'error';
                }
            }
            
        }
        session()->flash('message', $message);
        Session::flash('type', $type);
        Session::flash('title', $title);
        return redirect()->back(); 
    }

    public function printReceipt(Payment $payment)
    {
        $data['page_title'] = $payment->user->first_name.' Payment Receipt'; 
        $data['payment'] = $payment;
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('en');

        $data['words'] = $numberTransformer->toWords($payment->paid); 
        return view('admin.receipt', $data);
    }

    public function studentInfo(User $user)
    {
        $data['page_title'] = $user->first_name.' Information Details'; 
        $data['user'] = $user;
        $data['services'] = Service::whereUser_id($user->id)->get();
        return view('admin.info-students', $data);
    }

    public function editStudent(User $user)
    {
        $data['page_title'] = 'Edit '.$user->first_name.' Data'; 
        $data['user'] = $user;
        $data['services'] = Course::all();
        return view('admin.edit-students', $data);
    }

    public function updateStudent(Request $request)
    {
        try{
            DB::beginTransaction();
            $student = User::findorFail($request->user_id);
            $student->first_name=$request->first_name;
            $student->last_name=$request->last_name;
            $student->email=$request->email;
            $student->phone=$request->phone_number;       
            $student->update();

            //profile 
            $profile = Profile::whereUser_id($request->user_id)->first();
            $profile->dob = $request->dob;
            $profile->pob = $request->pob;
            $profile->passport = $request->passport_number;
            $profile->passport_expiry = $request->passport_expiry;
            $profile->profession = $request->profession;
            $profile->language = $request->language;
            $profile->country = $request->country;
            $profile->street = $request->street_address;
            $profile->city = $request->city;
            $profile->update();

            //emergency
            $emerge = Emergency::whereUser_id($request->user_id)->first();
            $emerge->name = $request->emergency;
            $emerge->phone = $request->emergency_phone;
            $emerge->address = $request->emergency_address;
            $emerge->update();
            if(Auth::user()->role!='developer'){
                $this->logActivity(Auth::user()->name, Auth::user()->branch, "Updated new client info - ID: ". $student->student_id." FirstName: ".$student->first_name);
            }
            DB::commit();
            $message = 'Student updated successful';
            $title = 'Updated';
            $type = 'success';
        }catch(\Exception $e){
            DB::rollBack();
            $message = 'Something went wrong';
            $title = 'Opps';
            $type = 'error';
        }

        session()->flash('message', $message);
        Session::flash('type', $type);
        Session::flash('title', $title);
        return redirect()->back();
    
    }

    public function destroyStudent(User $user)
    {
        if(Auth::user()->role!='developer'){
            $this->logActivity(Auth::user()->name, Auth::user()->branch, "Deleted client info - ID: ". $user->student_id." FirstName: ".$user->first_name);
        }
        $user->delete();
        session()->flash('message', 'Student deleted successful');
        Session::flash('type', 'success');
        Session::flash('title', 'Deleted');
        return redirect()->back();
    }

    public function addService(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'user_id' => 'required|string',
            'branch' => 'required|string',
            'service' => 'required|string',
        ]);

        if ($validator->fails()){
            $message = 'Something went wrong with your inputs. Try again.';
            $title = 'Opps';
            $type = 'error';
        }
        else{  
            if(Service::whereUser_id($request->user_id)->whereType($request->service)->exists())
            {
                $message = 'Already signed up for '.$request->service;
                $title = 'Opps';
                $type = 'error';
            }
            else
            {
                $payable = Price::whereBranch($request->branch)->whereCourse($request->service)->first();
                if(empty($payable)){
                    $message = $request->service.' price is not set';
                    $title = 'Opps';
                    $type = 'error';
                }
                else{
                    try{
                        DB::beginTransaction();
                        $service = new Service;
                        $service->user_id = $request->user_id;
                        $service->type = $request->service;
                        $service->payable = $payable->amount;
                        $service->save();
                        //update user payable
                        $user = User::findorFail($request->user_id);
                        $user->payable = $user->payable+$payable->amount;
                        $user->balance = $user->balance + $payable->amount;
                        $user->update();
                        if(Auth::user()->role!='developer'){
                            $this->logActivity(Auth::user()->name, Auth::user()->branch, $request->service." service added for - ID: ". $service->user->student_id." FirstName: ".$service->user->first_name);
                        }
                        DB::commit();
                        $message = 'Service added successful';
                        $title = 'Saved';
                        $type = 'success';
                    }catch(\Exception $e){
                        DB::rollBack();
                        $message = 'Something went wrong';
                        $title = 'Opps';
                        $type = 'error';
                    }
                }
            }
        }

        session()->flash('message', $message);
        Session::flash('type', $type);
        Session::flash('title', $title);
        return redirect()->back();        
    }

    public function transferStudent(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'user_id' => 'required|string',
            'branch' => 'required|string',
        ]);

        if ($validator->fails()){
            $message = 'Something went wrong with your inputs. Try again.';
            $title = 'Opps';
            $type = 'error';
        }
        else{  
            try{
                DB::beginTransaction();
                $user = User::findorFail($request->user_id);
                if(Auth::user()->role!='developer'){
                    $this->logActivity(Auth::user()->name, Auth::user()->branch, "Transfered client - ID: ". $user->student_id." FirstName: ".$user->first_name." from ".$user->branch." to ".$request->branch);
                }
                $user->branch = $request->branch;
                $user->update();
                /* if(!empty($user->email)){
                    $data['first_name'] = $user->first_name;
                    $data['branch'] = $user->branch;
                    Mail::to($user->email)->send(new TransferMail($data));
                } */
                DB::commit();
                $message = 'Client transfered successful';
                $title = 'Transfered';
                $type = 'success';
            }catch(\Exception $e){
                DB::rollBack();
                $message = 'Something went wrong';
                $title = 'Opps';
                $type = 'error';
            }
        }

        session()->flash('message', $message);
        Session::flash('type', $type);
        Session::flash('title', $title);
        return redirect()->back();        
    }

    public function createService(User $user)
    {
        $data['page_title'] = $user->first_name.' Services'; 
        $data['services'] = Service::whereUser_id($user->id)->get();
        return view('admin.services', $data);
    }
    

    public function updateComment(Request $request, User $user)
    {
        $user->additional_info = $request->additional_info;
        $user->update();
        return redirect()->route('admin.viewstudent.incomplete');
    }

    //view incomplete registrations
    public function incompleteStudent()
    {
        $data['page_title'] = 'Incomplete Clients Registration'; 
        if(Auth::user()->branch=='HEAD OFFICE'){
            $data['users'] = User::whereComplete(false)->get();
        }
        else{
            $data['users'] = User::whereBranch(Auth::user()->branch)->whereComplete(false)->get();
        }
        $data['services'] = Course::all();
        $data['branches'] = Branch::all();
        return view('admin.view-incomplete-reg', $data);
    }


    //payments
    public function showMakePayment()
    {
        $data['page_title'] = 'Make Payments'; 
        $data['users'] = User::where('balance','>',0)->whereComplete(true)->get();
        return view('admin.defaulters', $data);
    }

    public function storePayment(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'old_amount' => 'required|numeric',
        ]);

        if ($validator->fails()){
            $message = 'Something went wrong with your inputs. Try again.';
            $title = 'Opps';
            $type = 'error';
        }else
        {
            if($request->amount>$request->old_amount){
                $message = 'Amount exceed debt';
                $title = 'Exceed';
                $type = 'error';
            }else{
                try{
                    DB::beginTransaction();
                    $pay = new Payment;
                    $pay->user_id = $request->user_id;
                    $pay->receipt_no = $this->findReceipt();
                    $pay->payable=$request->old_amount;
                    $pay->paid=$request->amount;
                    $pay->owe=$request->old_amount - $request->amount;
                    $pay->save();
    
                    //update 
                    $user = User::findorFail($request->user_id);
                    $user->paid= $user->paid + $request->amount;
                    $user->balance= $user->balance - $request->amount;
                    $user->complete= true;
                    $user->update();
                    if(Auth::user()->role!='developer'){
                        $this->logActivity(Auth::user()->name, Auth::user()->branch, "Recieved payment from ". $user->student_id." FirstName: ".$user->first_name." - paid: GHs".number_format($pay->paid,2));
                    }
                    DB::commit();
                    $message = 'Amount received successful';
                    $title = 'Received';
                    $type = 'success';
                    return redirect()->route('admin.makepayment.receipt', $pay->id);
                }catch(\Exception $e){
                    DB::rollBack();
                    $message = 'Something went wrong'.$e->getMessage();
                    $title = 'Opps';
                    $type = 'error';
                }
            }
        }
        
        session()->flash('message', $message);
        Session::flash('type', $type);
        Session::flash('title', $title);
        return redirect()->back();
    }

    public function findReceipt()
    {
        $receipt = Payment::orderBy('id', 'DESC')->first();
        if(empty($receipt)){
            $recno = 'DC-'.gmdate('Y').'100';
        }
        else{
            $no = substr($receipt->receipt_no, 7);
            $recno = 'DC-'.gmdate('Y').($no+1);
        }
        return $recno;
    }

    public function showReceipt(Payment $payment)
    {
        $data['page_title'] = $payment->user->first_name.' Payment Receipt'; 
        $data['payment'] = $payment;
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('en');

        $data['words'] = $numberTransformer->toWords($payment->paid); 
        return view('admin.receipt', $data);
    }

    public function showPayments(User $user)
    {
        $data['page_title'] = $user->first_name.' Payment List'; 
        $data['payment'] = Payment::whereUser_id($user->id)->get();
        return view('admin.payment-list', $data);
    }

    public function logActivity($name, $branch="HEAD OFFICE", $action){
        $log = new Log;
        $log->name = $name;
        $log->branch = $branch;
        $log->action = $action;
        $log->save();
    }
    

}

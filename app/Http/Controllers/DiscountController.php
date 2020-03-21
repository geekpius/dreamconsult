<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use App\AdminModel\Log;
use App\AdminModel\Course;
use App\Mail\DiscountMail;
use App\AdminModel\Service;
use App\AdminModel\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class DiscountController extends Controller
{
    public function __construct()
    {
        $this->middleware('verify-admin');
        $this->middleware('auth:admin');
    }


    
    public function index()
    {
        $data['page_title'] = 'Discount GiveOut'; 
        $data['users'] = Discount::whereStatus(true)->get();
        $data['services'] = Course::all();
        return view('admin.discount', $data);
    }

    public function checkID(Request $request)
    {
        $user = User::whereStudent_id($request->client_id)->first();
        if(empty($user)){
            return 'Client does not exist';
        }
        elseif($user->status){
            return 'Client already completed';
        }
        else{
            return 'Client is available';
        }
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'client_id' => 'required|string',
            'service' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()){
            $message = 'Something went wrong with your inputs. Try again.';
            $title = 'Opps';
            $type = 'error';
        }
        else{  
            $user = User::whereStudent_id($request->client_id)->first();
            if(empty($user)){
                $message = 'Client does not exist';
                $title = 'Opps';
                $type = 'error';
            }elseif($user->status){
                $message = 'Client already completed';
                $title = 'Completed';
                $type = 'warning';
            }else{
                $service = Service::whereUser_id($user->id)->whereType($request->service)->first();
                if(empty($service)){
                    $message = 'Client does not have '.$request->service.' service';
                    $title = 'Opps';
                    $type = 'error';
                }
                elseif(($service->payable-$service->paid)<$request->amount){
                    $message = 'Payable amount left for '.$request->service.' service(GHs'.number_format(($service->payable-$service->paid),2).') is less than discount amount.';
                    $title = 'Opps';
                    $type = 'error';
                }
                else{
                    try{
                        DB::beginTransaction();
                        $discount= new Discount;
                        $discount->user_id = $user->id;
                        $discount->service = $request->service;
                        $discount->amount = $request->amount;
                        $discount->status = true;
                        $discount->save();
                        
                        //pay
                        $service->paid = $service->paid+$request->amount;
                        $service->update();

                        //update user
                        $user->paid = ($user->paid + $request->amount);
                        $user->balance = ($user->balance - $request->amount);
                        $user->update();

                        //send email
                        if(!empty($user->email)){
                            $data['first_name'] = $user->first_name;
                            $data['for'] = $discount->service;
                            $data['discount'] = $discount->amount;
                            Mail::to($user->email)->send(new DiscountMail($data));
                        }

                        if(Auth::user()->role!='developer'){
                            $this->logActivity(Auth::user()->name, Auth::user()->branch, "Gave out discount of GHs".number_format($discount->amount,2)." to ID# ".$discount->user->student_id." - FirstName: ".$discount->user->first_name);
                        }
                        DB::commit();
                        $message = 'Discounted successful. Email is sent to client';
                        $title = 'Discounted';
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


    public function logActivity($name, $branch="HEAD OFFICE", $action){
        $log = new Log;
        $log->name = $name;
        $log->branch = $branch;
        $log->action = $action;
        $log->save();
    }
    

}

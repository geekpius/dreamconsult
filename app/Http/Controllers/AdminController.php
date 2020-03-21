<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use App\Admin;
use App\Staff;
use Carbon\Carbon;
use App\AdminModel\Log;
use App\Mail\SignupMail;
use App\AdminModel\Branch;
use App\AdminModel\Course;
use App\AdminModel\Payment;
use App\AdminModel\Service;
use App\AdminModel\Visitor;
use Illuminate\Support\Str;
use App\AdminModel\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ChangePasswordRequest;

class AdminController extends Controller
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
    public function index()
    {
        $data['page_title'] = 'Dashboard'; 
        $data['count_visitors'] = Visitor::count();
        $data['count_new_visitors'] = User::whereComplete(false)->count();
        $data['count_clients'] = User::count();
        $data['count_debtors'] = User::where('balance','>',0)->count();
        $data['count_payers'] = User::where('balance','<=',0)->count();
        $data['total_debts'] = User::sum('balance');
        $data['total_pays'] = User::sum('paid');
        $data['branches'] = Branch::orderBy('id')->get();
        
        $data['tdaily'] = Payment::whereDate('created_at','=',Carbon::today())->sum('paid');
        $data['tweekly'] = Payment::whereDate('created_at','>=', Carbon::now()->startOfWeek()->format('Y-m-d'))->whereDate('created_at','<=',Carbon::now()->endOfWeek()->format('Y-m-d'))->sum('paid');
        $data['tmonthly'] = Payment::whereMonth('created_at','>=', Carbon::now()->month)->sum('paid');
        $data['services'] = Course::orderBy('id')->get();
        $data['inservices'] = Course::whereStatus(true)->get();
        $data['outservices'] = Course::whereStatus(false)->get();
        
        if(Auth::user()->role=='front desk'){
            $data['count_visitors'] = Visitor::whereBranch(Auth::user()->branch)->count();
            $data['count_new_visitors'] = User::whereComplete(false)->whereBranch(Auth::user()->branch)->count();
            $data['count_clients'] = User::whereBranch(Auth::user()->branch)->count();
            $data['count_debtors'] = User::whereBranch(Auth::user()->branch)->where('balance','>',0)->count();
            $data['today_visitors'] = Visitor::whereBranch(Auth::user()->branch)->whereDate('created_at', '=', Carbon::today())->count();
            $data['today_clients'] = User::whereBranch(Auth::user()->branch)->whereDate('created_at', '=', Carbon::today())->count();
        }
        return view('admin.dashboard', $data);
    }

    public function changePassword()
    {
        $data['page_title'] = 'Change Password';
        return view('admin.change-password', $data);
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        if(auth()->check()){
            if(Hash::check($request->current_password, Auth::user()->password)) 
            {
                $user = Admin::findorFail(Auth::user()->id);
                $user->password = Hash::make($request->password);
                $user->update();
                if($user){
                    if(Auth::user()->role!='developer'){
                        $this->logActivity(Auth::user()->name, Auth::user()->branch, "Created new user account - ".$user->name);
                    }
                    $msg = 'Password changed successful.';
                    $title = 'Changed';
                    $type = 'success';
                }else{
                    $msg = 'Unable to change password.';
                    $title = 'Opps';
                    $type = 'error';
                }
            }else
            {
                $msg = 'Incorrect current password.';
                $title = 'Opps';
                $type = 'warning';
            }

            session()->flash('message', $msg);
            Session::flash('type', $type);
            Session::flash('title', $title);
            return redirect()->back();
        }
    }

    public function users()
    {
        $data['page_title'] = 'Users';
        $data['users'] = Admin::where('role','!=', 'developer')->get();
        $data['branches'] = Branch::all();
        return view('admin.users', $data);
    }

    public function submitUsers(Request $request){
        $validator = \Validator::make($request->all(), [
            'fullname' => 'required|string',
            'email' => 'required|string|email|unique:admins',
            'phone' => 'required|string|unique:admins',
            'branch' => 'required|string',
            'user_type' => 'required|string',
        ]);

        if ($validator->fails()){
            $message = 'Something went wrong with your inputs(eg:existance email or phone, invalid format, etc). Try again.';
            $title = 'Opps';
            $type = 'error';
        }
        else{  
            try{
                DB::beginTransaction();
                $user = new Admin;
                $user->name=$request->fullname;
                $user->email = $request->email;
                $user->phone=$request->phone;
                $user->branch=$request->branch;
                $user->role = $request->user_type;
                $password = "123456";
                $user->password = Hash::make($password);
                $user->save();
                // send email
                $data['name']= $user->name;
                $data['password']= $password;
                Mail::to($user->email)->send(new SignupMail($data));
                
                if(Auth::user()->role!='developer'){
                    $this->logActivity(Auth::user()->name, Auth::user()->branch, "Created new user account - ".$user->name);
                }
                DB::commit();
                $message = 'Created users successful with password '.$password.'. Credentials sent to email.';
                $title = 'Created';
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

    public function edit(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'fullname' => 'required|string',
            'phone' => 'required|string',
            'user_type' => 'required|string',
            'user_id' => 'required|string',
        ]);

        if ($validator->fails()){
            $message = 'Something went wrong with your inputs. Try again.';
            $title = 'Opps';
            $type = 'error';
        }
        else{  
            try{
                DB::beginTransaction();
                $user = Admin::findorFail($request->user_id);
                $user->name=$request->fullname;
                $user->phone=$request->phone;
                $user->role=$request->user_type;
                $user->update();

                if(Auth::user()->role!='developer'){
                    $this->logActivity(Auth::user()->name, Auth::user()->branch, "Updated user account - ".$user->name.", ".$user->role);
                }
                DB::commit();
                $message = 'Updated user successful';
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

    public function blockUnblock(Admin $admin)
    {
        if($admin->active){
            $admin->active = false;
            $msg ='blocked';
        }else{
            $admin->active= true;
            $msg ='unblocked';
        }
        $admin->update();
        if(Auth::user()->role!='developer'){
            $this->logActivity(Auth::user()->name, Auth::user()->branch, ucfirst($msg)." user account - ".$admin->name);
        }
        session()->flash('message', "User account ".$msg." successful");
        Session::flash('type', 'success');
        Session::flash('title', ucfirst($msg));
        return redirect()->back();
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        if(Auth::user()->role!='developer'){
            $this->logActivity(Auth::user()->name, Auth::user()->branch, "Deleted user account - ".$admin->name);
        }
        $admin->delete();
        session()->flash('message', "User deleted successful");
        Session::flash('type', 'success');
        Session::flash('title', 'Deleted');
        return redirect()->back();
    }

    public function transferStaff(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'branch' => 'required|string',
            'user_id' => 'required|string',
        ]);

        if ($validator->fails()){
            $message = 'Something went wrong with your inputs. Try again.';
            $title = 'Opps';
            $type = 'error';
        }
        else{  
            try{
                DB::beginTransaction();
                $user = Admin::findorFail($request->user_id);
                if(Auth::user()->role!='developer'){
                    $this->logActivity(Auth::user()->name, Auth::user()->branch, "Transfered user account(".$user->name.") from ".$user->branch." to ".$request->branch);
                }
                $user->branch=$request->branch;
                $user->update();
                DB::commit();
                $message = 'User transfered successful';
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

    public function notification()
    {
        $data['users'] = User::whereDiscount_check(false)->whereComplete(false)->get();
        return view('admin.notification', $data)->render();
    }

    public function notiTop()
    {
        $count_users = User::whereDiscount_check(false)->whereComplete(false)->count();
        return $count_users;
    }

    public function approveDiscount(Request $request)
    {
        $user = User::findOrFail($request->id);
        $discount = Discount::whereUser_id($request->id)->whereStatus(false)->orderBy('id', 'DESC')->first();
        $service = Service::whereUser_id($request->id)->whereType($discount->service)->first();
        if(empty($service)){
            $message = 'Client does not have '.$discount->service.' service';
        }
        elseif(($service->payable-$service->paid)<$discount->amount){
            $message = 'Payable amount left for '.$discount->service.' service(GHs'.number_format(($service->payable-$service->paid),2).') is less than discount amount.';
        }
        else{
            try{
                DB::beginTransaction();
                $user->discount_check=true;
                $user->update();

                if(Auth::user()->role!='developer'){
                    $this->logActivity(Auth::user()->name, Auth::user()->branch, "Gave out discount of GHs".number_format($discount->amount,2)." to ID# ".$user->student_id." - FirstName: ".$user->first_name);
                }
                DB::commit();
                $message = 'success';
            }catch(\Exception $e){
                DB::rollBack();
                $message = 'Something went wrong';
            }
        }

        return $message;
    }

    public function rejectDiscount(Request $request)
    {
        try{
            DB::beginTransaction();
            $user = User::findorFail($request->id);
            $discount = Discount::whereUser_id($user->id)->whereStatus(false)->orderBy('id','DESC')->first();
            $discount->delete();
            ///checked
            $user->discount_check = true;
            $user->update();

            if(Auth::user()->role!='developer'){
                $this->logActivity(Auth::user()->name, Auth::user()->branch, "Rejected discount approval of (".$user->student_id." - ".$user->first_name.") from ".$user->branch);
            }
            DB::commit();
            $message = 'User transfered successful';
        }catch(\Exception $e){
            DB::rollBack();
            $message = 'Something went wrong';
        }

        return $message;
    }


    public function logActivity($name, $branch="HEAD OFFICE", $action){
        $log = new Log;
        $log->name = $name;
        $log->branch = $branch;
        $log->action = $action;
        $log->save();
    }



}

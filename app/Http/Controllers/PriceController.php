<?php

namespace App\Http\Controllers;

use DB;
use App\AdminModel\Log;
use App\AdminModel\Price;
use App\AdminModel\Branch;
use App\AdminModel\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PriceController extends Controller
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
        $data['page_title'] = 'Prices'; 
        $data['prices'] = Price::all(); 
        $data['courses'] = Course::all(); 
        $data['branches'] = Branch::all(); 
        return view('admin.prices', $data);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'service' => 'required|string',
            'branch' => 'required|string',
            'price' => 'required|string',
        ]);

        if ($validator->fails()){
            $message = 'Something went wrong with your inputs. Try again.';
            $title = 'Opps';
            $type = 'error';
        }
        else{  
            if(Price::whereCourse($request->service)->whereBranch($request->branch)->exists()){
                $message = 'This price set is already exist.';
                $title = 'Opps';
                $type = 'error';
            }
            else{
                try{
                    DB::beginTransaction();
                    $price = new Price;
                    $price->course=$request->service;
                    $price->branch=$request->branch;
                    $price->amount=$request->price;
                    $price->save();
                    if(Auth::user()->role!='developer'){
                        $this->logActivity(Auth::user()->name, Auth::user()->branch, "Saved new price - ".$price->course." - ".$price->branch." - GHs".number_format($price->amount,2));
                    }
                    DB::commit();
                    $message = 'Price saved successful';
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

        session()->flash('message', $message);
        Session::flash('type', $type);
        Session::flash('title', $title);
        return redirect()->back();
    }

    public function edit(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'price' => 'required|string',
        ]);

        if ($validator->fails()){
            $message = 'Something went wrong with your inputs. Try again.';
            $title = 'Opps';
            $type = 'error';
        }
        else{  
            try{
                DB::beginTransaction();
                $price = Price::findorFail($request->price_id);
                if(Auth::user()->role!='developer'){
                    $this->logActivity(Auth::user()->name, Auth::user()->branch, "Updated  price from ".$price->course." - ".$price->branch." - GHs".number_format($price->amount,2)." to GHs ".number_format($request->price,2));
                }
                $price->amount=$request->price;
                $price->update();
                DB::commit();
                $message = 'Price updated successful';
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
    
    public function destroy(Price $price)
    {
        if(Auth::user()->role!='developer'){
            $this->logActivity(Auth::user()->name, Auth::user()->branch, "Deleted  price - ".$price->course." - ".$price->branch." - GHs".number_format($price->amount,2));
        }
        $price->delete();
        session()->flash('message', "Price deleted successful");
        Session::flash('type', 'success');
        Session::flash('title', 'Deleted');
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

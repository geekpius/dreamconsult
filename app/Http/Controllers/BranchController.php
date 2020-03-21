<?php

namespace App\Http\Controllers;

use DB;
use App\AdminModel\Log;
use App\AdminModel\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BranchController extends Controller
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
        $data['page_title'] = 'Branches'; 
        $data['branches'] = Branch::all(); 
        return view('admin.branch', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'branch' => 'required|string',
            'branch_color' => 'required|string',
        ]);

        if ($validator->fails()){
            $message = 'Something went wrong with your inputs. Try again.';
            $title = 'Opps';
            $type = 'error';
        }
        else{  
            try{
                DB::beginTransaction();
                $branch = new Branch;
                $branch->name=$request->branch;
                $branch->branch_color=$request->branch_color;
                $branch->save();

                if(Auth::user()->role!='developer'){
                    $this->logActivity(Auth::user()->name, Auth::user()->branch, "Saved new branch - ".$branch->name);
                }
                DB::commit();
                $message = 'Branch saved successful';
                $title = 'Saved';
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


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AdminModel\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        if(Auth::user()->role!='developer'){
            $this->logActivity(Auth::user()->name, Auth::user()->branch, "Deleted branch - ".$branch->name);
        }
        $branch->delete();
        session()->flash('message', "Branch deleted successful");
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

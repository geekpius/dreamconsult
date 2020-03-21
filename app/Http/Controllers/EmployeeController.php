<?php

namespace App\Http\Controllers;

use DB;
use App\Admin;
use App\AdminModel\Tax;
use App\AdminModel\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('verify-admin');
        $this->middleware('auth:admin');
    }


    ///view company employee
    public function index()
    {
        $data['page_title'] = 'Employees';
        $data['users'] = Admin::where('role','!=','developer')->orderBy('id','DESC')->get();
        return view('admin.employees', $data);
    }

    // job positions
    public function jobPosition()
    {
        $data['page_title'] = 'Job Positions';
        $data['positions'] = Position::all();
        return view('admin.job-positions', $data);
    }

    //save positions
    public function submitPosition(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'position_name' => 'required|string',
            'gross_pay' => 'required|numeric',
        ]);

        if ($validator->fails()){
            $message = 'Something went wrong with your inputs. Try again.';
            $title = 'Opps';
            $type = 'error';
        }else
        {
            try{
                DB::beginTransaction();
                $position = new Position;
                $position->name = $request->position_name;
                $position->gross = $request->gross_pay;
                $position->save();
                if(Auth::user()->role!='developer'){
                    $this->logActivity(Auth::user()->name, Auth::user()->branch, "Saved position ". $position->name." with gross pay GHs ".number_format($position->gross,2));
                }
                DB::commit();
                $message = 'Position saved successful';
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

    //update positions
    public function updatePosition(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'position_id' => 'required|string',
            'position_name' => 'required|string',
            'gross_pay' => 'required|numeric',
        ]);

        if ($validator->fails()){
            $message = 'Something went wrong with your inputs. Try again.';
            $title = 'Opps';
            $type = 'error';
        }else
        {
            try{
                DB::beginTransaction();
                $position = Position::findOrFail($request->position_id);
                $position->name = $request->position_name;
                $position->gross = $request->gross_pay;
                $position->update();
                if(Auth::user()->role!='developer'){
                    $this->logActivity(Auth::user()->name, Auth::user()->branch, "Updated position ". $position->name." with gross pay GHs ".number_format($position->gross,2));
                }
                DB::commit();
                $message = 'Position updated successful';
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

    ///delete position
    public function deletePosition(Position $position)
    {
        try{
            DB::beginTransaction();
            if(Auth::user()->role!='developer'){
                $this->logActivity(Auth::user()->name, Auth::user()->branch, "Deleted position ". $position->name." with gross pay GHs ".number_format($position->gross,2));
            }
            $position->delete();
            DB::commit();
            $message = 'Position deleted successful';
            $title = 'Deleted';
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

    // taxes, snnit
    public function tax()
    {
        $data['page_title'] = 'Taxes';
        $data['tax'] = Tax::first();
        return view('admin.taxes', $data);
    }

    ///update taxes
    public function submitTax(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'tax' => 'required|numeric',
            'ssnit' => 'required|numeric',
            'other' => 'required|numeric',
        ]);

        if ($validator->fails()){
            $message = 'Something went wrong with your inputs. Try again.';
        }else
        {
            try{
                DB::beginTransaction();
                $tax = Tax::first();
                $tax->tax = $request->tax;
                $tax->snnit = $request->ssnit;
                $tax->other = $request->other;
                $tax->update();
                if(Auth::user()->role!='developer'){
                    $this->logActivity(Auth::user()->name, Auth::user()->branch, "Updated taxes - Tax: ". $tax->tax.", SSNIT: ".$tax->snnit.", Other: ".$tax->other);
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

    // salary structure
    public function salaryStructure()
    {
        $data['page_title'] = 'Salary Structure';
        $data['users'] = Admin::where('role','!=','developer')->orderBy('id','DESC')->get();
        return view('admin.salary-structure', $data);
    }


    // deductions
    public function deduction()
    {
        $data['page_title'] = 'Deductions';
        return view('admin.deductions', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

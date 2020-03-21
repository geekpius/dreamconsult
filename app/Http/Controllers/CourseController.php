<?php

namespace App\Http\Controllers;

use DB;
use App\AdminModel\Log;
use App\AdminModel\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CourseController extends Controller
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
        $data['page_title'] = 'Services'; 
        $data['courses'] = Course::all(); 
        return view('admin.courses', $data);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'service' => 'required|string',
            'service_color' => 'required|string',
            'status' => 'required|string',
        ]);

        if ($validator->fails()){
            $message = 'Something went wrong with your inputs. Try again.';
            $title = 'Opps';
            $type = 'error';
        }
        else{  
            try{
                DB::beginTransaction();
                $course = new Course;
                $course->name=$request->service;
                $course->color=$request->service_color;
                $course->status=$request->status;
                $course->save();

                if(Auth::user()->role!='developer'){
                    $this->logActivity(Auth::user()->name, Auth::user()->branch, "Saved new service - ".$course->name);
                }
                DB::commit();
                $message = 'Service saved successful';
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

    public function update(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'service' => 'required|string',
            'status' => 'required|string',
        ]);

        if ($validator->fails()){
            $message = 'Something went wrong with your inputs. Try again.';
            $title = 'Opps';
            $type = 'error';
        }
        else{  
            try{
                DB::beginTransaction();
                $course = Course::findOrFail($request->service_id);
                $course->name=$request->service;
                $course->status=$request->status;
                $course->update();

                if(Auth::user()->role!='developer'){
                    $this->logActivity(Auth::user()->name, Auth::user()->branch, "Updated service - ".$course->name);
                }
                DB::commit();
                $message = 'Service updated successful';
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
    
    public function destroy(Course $course)
    {
        if(Auth::user()->role!='developer'){
            $this->logActivity(Auth::user()->name, Auth::user()->branch, "Deleted service - ".$course->name);
        }
        $course->delete();
        session()->flash('message', "Service deleted successful");
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

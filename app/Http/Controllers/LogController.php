<?php

namespace App\Http\Controllers;

use App\AdminModel\Log;
use Illuminate\Http\Request;

class LogController extends Controller
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
        $data['page_title'] = 'Logs';
        $data['logs'] = Log::orderBy('id','DESC')->get();
        return view('admin.logs', $data);
    }

    

}

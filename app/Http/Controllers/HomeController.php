<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Sip_ref_activity;
use App\Sip_ref_form;
use App\Sip_ref_sub_form;
use App\Sip_ref_column;
use App\Sip_ref_row;
use App\Sip_trx_row_value;
use App\Sip_trx_form_value;

use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function testValue()
    {
        return view('demo.test.value');
    }

    public function testDhis()
    {
        return view('demo.test.dhis2');
    }
    
    public function index()
    {
        return redirect('login');
    }

}

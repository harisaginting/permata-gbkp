<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Harisa;
use Session;
use DB;


class EventController extends Controller
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

    function index()
    {   
        echo "No Direct Access Allowed";die();
    }

    function rakor3()
    {   
        return view('event.rakor3.main');
    }

    function rakor3attendance($phone = null)
    {   
        $user = DB::table('event_rakor3')->where('phone', $phone)->first();
        
        if(empty($user)){echo 'no user found';die;}

        return view('event.rakor3.attendance', compact('user'));
    }

    function rakor3setattendance($phone = null,$present = '1')
    {   

        DB::table('event_rakor3')
            ->where('phone', $phone )
            ->update(array('attend' => $present, 'date_updated' => Carbon::now()));
    
        return redirect()->action('EventController@rakor3attendance',array('phone'=>$phone))->with('message', 'data kehadiran enggo iperbarui!');
    }

    function rakor3scanner(){
        // echo json_encode(Session::get('email'));
        return view('event.rakor3.scanner');
    }
}
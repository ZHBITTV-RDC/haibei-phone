<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;

use App\Http\Requests;

class NewteamController extends Controller
{
    //
     public function head(){

    	return view('newteam.head');
    }

    public function application_One(){

    	return view('newteam.application_One');
    }

    public function application_Two(){

    	return view('newteam.application_Two');

    }

    public function application_Three(){

    	return view('newteam.application_Three');
    	
    }

    public function application_Four(){

    	return view('newteam.application_Four');
    	
    }

   
}

<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    function index(){

        $result = Result::where('user_id','=',getUserID())
            ->orderBy('created_at','DESC')
            ->first();

       return view("results", compact('result'));
    }

}

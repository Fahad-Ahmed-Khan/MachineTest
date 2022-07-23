<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function setUser()
    {
        $user_name = request()->get('user_name');
        $user = User::firstOrCreate(['name'=> $user_name]);
        setUserID($user->id); //Set user id in session

        $response = [
            "user" => $user,
            "success" => true
        ];
        return response()->json($response);
    }

    function logout(){
        unsetUserID();
        return redirect('/');
    }
}

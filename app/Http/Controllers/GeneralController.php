<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function profile(){

        $profile = \CanvasApi::using("users")->getUserProfile()->getContent();
        return view("general.profile",[
            "profile" => $profile
        ]);
    }
}

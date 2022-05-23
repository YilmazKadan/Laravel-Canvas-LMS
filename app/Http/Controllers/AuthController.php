<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function responseAuth(Request $request)
    {

        $code = $request->code;
        if (!empty($code)) {
            $response = Http::post('https://oys-staging.anadolu.edu.tr/login/oauth2/token', [
                'client_id' => '10000000000003',
                'client_secret' => 'EdyRRmzoMNpPJ4c4inK0ZiEU7yPTSrDno0kuZezSUCM8IJ5DVXt3Xsk4OQrgU6Tb',
                'code' => $code,
            ]);

            if (!empty($response['access_token'])) {
                Session::put('access_token', $response['access_token']);
            } else {
                return redirect("/giris");
            }
            return redirect("/");
        }
    }

    public function logout(){
        $response = Http::delete("https://oys-staging.anadolu.edu.tr/login/oauth2/token");
        Session::forget("access_token");
        return redirect('/giris');
    }
}

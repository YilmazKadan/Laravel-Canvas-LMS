<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Uncgits\CanvasApiLaravel\CanvasApi;

class AccountsController extends Controller
{

    public function index()
    {
        $api = new CanvasApi;
        $api->setClient(new \Uncgits\CanvasApi\Clients\Accounts);

        $accounts = $api->listAccounts()->getContent();
        return view("accounts.index", compact('accounts'));
    }

    public function specific(Request $request, $id){

        $dersler = \CanvasApi::using('accounts')->listActiveCoursesInAccount($id)->getContent();
        $terms = \CanvasApi::using('enrollmentterms')->listEnrollmentTerms($id)->getContent();

        $api = new  CanvasApi;
        $api->setClient(new \Uncgits\CanvasApi\Clients\Accounts);

        $accounts = \CanvasApi::using("accounts")->listAccounts()->getContent();
        ;
        $account = $api->getAccount($id)->getContent();
        return view('accounts.accounts',[
            "id" => $id,
            "account" => $account,
            "dersler" => $dersler,
            "accounts" => $accounts,
            "terms" => $terms
        ]);
    }

}

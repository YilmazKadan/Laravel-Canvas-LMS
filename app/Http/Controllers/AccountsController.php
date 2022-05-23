<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountsController extends Controller
{

    public function index()
    {
        $api = new \Uncgits\CanvasApiLaravel\CanvasApi;
        $api->setClient(new \Uncgits\CanvasApi\Clients\Accounts);

        $accounts = $api->listAccounts()->getContent();
        return view("accounts.index", compact('accounts'));
    }

    public function specific($id){
        $api = new \Uncgits\CanvasApiLaravel\CanvasApi;
        $api->setClient(new \Uncgits\CanvasApi\Clients\Accounts);

        $account = $api->getAccount($id)->getContent();
        return view('accounts.accounts',[
            "id" => $id,
            "account" => $account
        ]);
    }
    //List users in account
    public function users($accountId){
        $api = new \Uncgits\CanvasApiLaravel\CanvasApi;
        $api->setClient(new \Uncgits\CanvasApi\Clients\Users);

        $users = $api->listUsersInAccount($accountId)->getContent();
        return view("accounts.accountusers", compact('users'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Uncgits\CanvasApiLaravel\CanvasApi;

class AccountsTermsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($accountId)
    {
        $donemler = \CanvasApi::using('enrollmentterms')->listEnrollmentTerms($accountId)->getContent();
        return view("accounts.terms.index",[
            "donemler" => $donemler
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$account_id)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'start_at' => 'required',
            'end_at' => 'required'
        ]);
        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $fields = [
            "enrollment_term" => [
                "name" => $request->name,
                "start_at" =>$request->start_at,
                "end_at" => $request->end_at
            ]
        ];

        $api = new CanvasApi;
        $api->setClient(new \Uncgits\CanvasApi\Clients\EnrollmentTerms);

        $result = $api->addParameters($fields)->createEnrollmentTerm($account_id);

        if($result->getStatus() == "error"){
            return response()->json(["apierrors" => $result->errorMessage()]);
        }
        return response()->json(['success' => "Başarılı bir şekilde dönem kayıdı eklendi"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($account_id, $id)
    {
        $result = \CanvasApi::using('enrollmentterms')->deleteEnrollmentTerm($account_id,$id);

        if($result->getStatus() == "error"){
            return response()->json(["apierrors" => $result->errorMessage()]);
        }
        else if($result->getStatus() == "success"){
            return response()->json(["success" => "Başarılı bir şekilde silme işlemi gerçekleşti"]);
        }
    }
}

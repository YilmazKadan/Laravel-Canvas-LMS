<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Uncgits\CanvasApiLaravel\CanvasApi;

class CourseEnrollmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($courseId){
        $api = new CanvasApi;
        $api->setClient(new \Uncgits\CanvasApi\Clients\Enrollments);
        $enrollments = $api->listCourseEnrollments($courseId)->getContent();
        $course = \CanvasApi::using('courses')->getCourse($courseId)->throwAbort()->getContent();
        $roles = \CanvasApi::using('roles')->listRoles("self")->throwAbort()->getContent();
        $users = \CanvasApi::using('users')->listUsersInAccount("self")->throwAbort()->getContent();

        return view('courses.enrollments.index',[
            "course" => $course,
            "enrollments" => $enrollments,
            "roles" => $roles,
            "users" => $users
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
    public function store(Request $request, $courseId)
    {
        $validator = \Validator::make($request->all(),[
            "role_id" => "required",
            "user_id" => "required"
        ]);

        if($validator->fails()){
            return response()->json(["errors" => $validator->errors()->all()]);
        }

        $roleType = \CanvasApi::using('roles')->getRole("self",$request->role_id)->errorRedirect(true)->getContent()->base_role_type;
        $fields = [
            "enrollment" => [
                "user_id" => $request->user_id,
                "role_id" =>$request->role_id,
                "type" => $roleType
            ]
        ];

        $api = new CanvasApi;
        $api->setClient(new \Uncgits\CanvasApi\Clients\Enrollments);

        $result = $api->addParameters($fields)->enrollUserInCourse($courseId)->errorRedirect(true);

        return response()->json(["success" => "Kullanıcı başarılı bir şekilde hesap altına eklendi"]);
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
    public function destroy($id)
    {
        //
    }
}

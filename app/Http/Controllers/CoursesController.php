<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Uncgits\CanvasApiLaravel\CanvasApi;

class CoursesController extends Controller
{
    public function index()
    {
        $api = new CanvasApi;
        $api->setClient(new \Uncgits\CanvasApi\Clients\Courses);

        $result = $api->listCourses()->getContent();

        return view("courses", compact('result'));
    }
    public function store(Request $request){

        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'course_code' => 'required',
            'account_id' => 'required'
        ]);
        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $fields = [
            "course" => [
                "name" => $request->name,
                "course_code" =>$request->course_code
            ]
        ];

        $api = new CanvasApi;
        $api->setClient(new \Uncgits\CanvasApi\Clients\Courses);

        $result = $api->addParameters($fields)->createCourse($request->account_id);
        if($result->getStatus() == "error"){
            return response()->json(["apierrors" => $result->errorMessage()]);
        }
        return response()->json(['success',"Başarılı bir şekilde kayıt eklendi"]);
    }
    public function specific($id){
        $api = new CanvasApi;
        $api->setClient(new \Uncgits\CanvasApi\Clients\Courses);

        $name = $api->getCourse($id)->getContent()->name;

        return view('course',[
            "id" => $id,
            "name" => $name
        ]);
    }

    public function enrollments($courseId){
        $api = new CanvasApi;
        $api->setClient(new \Uncgits\CanvasApi\Clients\Enrollments);
        $users = $api->listCourseEnrollments($courseId)->getContent();

        return view('courseUsers',compact('users'));
    }
}

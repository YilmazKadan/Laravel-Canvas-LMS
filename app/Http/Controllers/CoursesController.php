<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use \Uncgits\CanvasApiLaravel\CanvasApi;

class CoursesController extends Controller
{
    public function index()
    {
        $api = new CanvasApi;
        $api->setClient(new \Uncgits\CanvasApi\Clients\Courses);

        $courses = $api->listCourses()->getContent();

        return view("courses.index", compact('courses'));
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
                "course_code" =>$request->course_code,
                "term_id" => $request->term_id
            ]
        ];

        $api = new CanvasApi;
        $api->setClient(new \Uncgits\CanvasApi\Clients\Courses);

        $result = $api->addParameters($fields)->createCourse($request->account_id);
        if($result->getStatus() == "error"){
            return response()->json(["apierrors" => $result->errorMessage()]);
        }
        return response()->json(['success' => "Başarılı bir şekilde kayıt eklendi"]);
    }
    public function spesific($id){
        $api = new CanvasApi;
        $api->setClient(new \Uncgits\CanvasApi\Clients\Courses);

        $course = $api->getCourse($id)->throwAbort()->getContent();

        return view("courses.coursesindex",[
            "course" => $course
        ]);
    }
    public function show($id){

    }
    public function create(){

    }

    public function enrollments($courseId){
        $api = new CanvasApi;
        $api->setClient(new \Uncgits\CanvasApi\Clients\Enrollments);
        $users = $api->listCourseEnrollments($courseId)->getContent();

        return view('courseUsers',compact('users'));
    }
}

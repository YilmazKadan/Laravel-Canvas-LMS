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

        $course = $api->addParameters([
            "include" => [
                "syllabus_body"
            ]
        ])->getCourse($id)->throwAbort()->getContent();
        $activityStream = $api->getCourseActivityStreamSummary($id)->errorRedirect()->getContent();
        return view("courses.coursesindex",[
            "course" => $course
        ]);
    }

//    Bir kursu öğrencilerden gizler
    public function publish($id){

        $api = new CanvasApi;
        $api->setClient(new \Uncgits\CanvasApi\Clients\Courses);
        $course = $api->addParameters(
            [
                "course" => [
                    "event" => "offer"
                ]
            ]
        )->updateCourse($id)->errorRedirect();

        return redirect()->back();
    }
//    Bir kursu öğrencilere görünür yapar
    public function unpublish($id){

        $api = new CanvasApi;
        $api->setClient(new \Uncgits\CanvasApi\Clients\Courses);
        $course = $api->addParameters(
            [
                "course" => [
                    "event" => "claim"
                ]
            ]
        )->updateCourse($id)->errorRedirect();

        return redirect()->back();
    }

}

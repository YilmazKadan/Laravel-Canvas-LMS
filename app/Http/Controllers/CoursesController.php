<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CanvasApi;

class CoursesController extends Controller
{
    public function index()
    {
        $api = new CanvasApi;
        $api->setClient(new \Uncgits\CanvasApi\Clients\Courses);

        $result = $api->listCourses()->getContent();

        return view("courses", compact('result'));
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

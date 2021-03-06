<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index($id)
    {
        $course = Course::where('id',$id)->where('status',1)->firstOrFail();
        $teacher = $course->author;

        $relates = Course::where('category_id', $course->category_id)
            ->where('id','!=',$course->id)
            ->take(2)
            ->get();


        return view('course',['course' => $course, 'relates' => $relates, 'teacher' => $teacher]);
    }
}

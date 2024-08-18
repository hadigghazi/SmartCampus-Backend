<?php

namespace App\Http\Controllers;

use App\Models\CoursePrerequisite;
use App\Http\Requests\StoreCoursePrerequisiteRequest;
use App\Http\Requests\UpdateCoursePrerequisiteRequest;

class CoursePrerequisiteController extends Controller
{
    public function index()
    {
        $coursePrerequisites = CoursePrerequisite::withTrashed()->get();
        return response()->json($coursePrerequisites);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSemesterRequest;
use App\Http\Requests\UpdateSemesterRequest;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::withTrashed()->get();
        return response()->json($semesters);
    }

   
}

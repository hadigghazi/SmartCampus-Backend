<?php

namespace App\Http\Controllers;

use App\Models\Dorm;
use App\Http\Requests\StoreDormRequest;
use App\Http\Requests\UpdateDormRequest;

class DormController extends Controller
{
    public function index()
    {
        $dorms = Dorm::withTrashed()->get();
        return response()->json($dorms);
    }

}

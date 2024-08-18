<?php

namespace App\Http\Controllers;

use App\Models\FacultyCampus;
use Illuminate\Http\Request;

class FacultyCampusController extends Controller
{
    public function index()
    {
        $facultiesCampuses = FacultyCampus::withTrashed()->get();
        return response()->json($facultiesCampuses);
    }

}

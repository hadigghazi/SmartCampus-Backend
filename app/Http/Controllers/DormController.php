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

    public function store(StoreDormRequest $request)
    {
        $dorm = Dorm::create($request->validated());
        return response()->json($dorm, 201);
    }

    public function show(Dorm $dorm)
    {
        return response()->json($dorm);
    }

    public function update(UpdateDormRequest $request, Dorm $dorm)
    {
        $dorm->update($request->validated());
        return response()->json($dorm);
    }

    public function destroy(Dorm $dorm)
    {
        $dorm->delete();
        return response()->json(null, 204);
    }

}

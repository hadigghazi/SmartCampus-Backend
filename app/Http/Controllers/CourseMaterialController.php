<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseMaterial;

class CourseMaterialController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_instructor_id' => 'required|exists:course_instructors,id',
            'file' => 'required|file|mimes:pdf,docx,pptx,zip|max:20480', 
        ]);

        $filePath = $request->file('file')->store('course_materials', 'public');
        $fileName = $request->file('file')->getClientOriginalName();

        $courseMaterial = CourseMaterial::create([
            'title' => $request->title,
            'description' => $request->description,
            'course_instructor_id' => $request->course_instructor_id,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'uploaded_by' => auth()->id(),
        ]);

        return response()->json($courseMaterial, 201);
    }

    public function index($courseInstructorId)
    {
        $materials = CourseMaterial::where('course_instructor_id', $courseInstructorId)->get();
        return response()->json($materials);
    }
    
    public function show($id)
    {
        $material = CourseMaterial::findOrFail($id);
        return response()->json($material);
    }
    
    public function download($id)
    {
        $material = CourseMaterial::findOrFail($id);
        return response()->download(storage_path('app/public/' . $material->file_path), $material->file_name);
    }
}

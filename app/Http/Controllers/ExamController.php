<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Http\Requests\StoreExam;
use App\Http\Requests\UpdateExam;

class ExamController extends Controller
{
    public function index()
    {
        $items = Exam::get();
        return response()->json($items);
    }

    public function store(StoreExam $request)
    {
        $item = Exam::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = Exam::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateExam $request, $id)
    {
        $item = Exam::withTrashed()->findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = Exam::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = Exam::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = Exam::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }

    public function getExamDetails($id)
    {
        $exam = Exam::findOrFail($id);

        if ($exam->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }

        $course = $exam->course; 
        $user = $instructor ? $instructor->user : null; 
        $room = $exam->room;
        $block = $room ? $room->block : null; 
        $campus = $block ? $block->campus : null; 

        $courseName = $course->name ?? 'N/A';
        $roomNumber = $room->number ?? 'N/A';
        $blockName = $block->name ?? 'N/A';
        $campusName = $campus->name ?? 'N/A';

        $examDetails = [
            'id' => $exam->id,
            'course_name' => $courseName,
            'date' => $exam->date,
            'time' => $exam->time,
            'duration' => $exam->duration,
            'room_number' => $roomNumber,
            'block_name' => $blockName,
            'campus_name' => $campusName,
            'created_at' => $exam->created_at,
            'updated_at' => $exam->updated_at,
            'deleted_at' => $exam->deleted_at,
        ];

        return response()->json($examDetails);
    }

    public function getAllExams()
    {
        try {
            $exams = Exam::with([
                'course',
                'room.block.campus' 
            ])->get();
    
            $examDetails = $exams->map(function($exam) {
                if ($exam->trashed()) {
                    return null; 
                }
    
                $courseName = $exam->course ? $exam->course->name : 'N/A';
                $roomNumber = $exam->room ? $exam->room->number : 'N/A';
                $blockName = $exam->room && $exam->room->block ? $exam->room->block->name : 'N/A';
                $campusName = $exam->room && $exam->room->block && $exam->room->block->campus ? $exam->room->block->campus->name : 'N/A';
    
                return [
                    'id' => $exam->id,
                    'course_name' => $courseName,
                    'date' => $exam->date,
                    'time' => $exam->time,
                    'duration' => $exam->duration,
                    'room_number' => $roomNumber,
                    'block_name' => $blockName,
                    'campus_name' => $campusName,
                    'created_at' => $exam->created_at,
                    'updated_at' => $exam->updated_at,
                    'deleted_at' => $exam->deleted_at,
                ];
            })->filter(); 
            return response()->json($examDetails);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }
}

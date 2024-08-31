<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Http\Requests\StoreRegistration;
use App\Http\Requests\UpdateRegistration;

class RegistrationController extends Controller
{
    public function index()
    {
        $items = Registration::get();
        return response()->json($items);
    }

    public function store(StoreRegistration $request)
    {
        $item = Registration::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
{
    $item = Registration::withTrashed()->findOrFail($id);
    if ($item->trashed()) {
        return response()->json(['error' => 'Not found'], 404);
    }
    return response()->json($item);
}

public function update(UpdateRegistration $request, $id)
{
    $item = Registration::withTrashed()->findOrFail($id);
    $item->update($request->validated());
    return response()->json($item);
}

public function destroy($id)
{
    $item = Registration::withTrashed()->findOrFail($id);
    $item->delete();
    return response()->json(null, 204);
}


    public function restore($id)
    {
        $item = Registration::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = Registration::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }

    public function getRegistrationsByStudent($studentId)
    {
        $registrations = Registration::with([
            'courseInstructor.course:id,code,name,credits',
            'courseInstructor.instructor.user:id,first_name,middle_name,last_name',
            'semester:id,name,start_date,end_date',
            'grade'
        ])
        ->where('student_id', $studentId)
        ->get()
        ->map(function ($registration) {
            $courseInstructor = $registration->courseInstructor;
            $course = $courseInstructor ? $courseInstructor->course : null;
            $instructor = $courseInstructor ? $courseInstructor->instructor : null;
            $instructorUser = $instructor ? $instructor->user : null;
            $semester = $registration->semester;
            $grade = $registration->grade;
            $schedule = $courseInstructor ? $courseInstructor->schedule : null;
    
            return [
                'id' => $registration->id,
                'course_code' => $course ? $course->code : 'N/A',
                'course_name' => $course ? $course->name : 'N/A',
                'credits' => $course ? $course->credits : 'N/A',
                'instructor_name' => $instructorUser 
                    ? $instructorUser->first_name . ' ' . $instructorUser->middle_name . ' ' . $instructorUser->last_name 
                    : 'N/A',
                'status' => $registration->status,
                'semester_id' => $semester ? $semester->id : 'N/A',
                'semester_name' => $semester ? $semester->name : 'N/A',
                'start_date' => $semester ? $semester->start_date : 'N/A',
                'end_date' => $semester ? $semester->end_date : 'N/A',
                'grade' => $grade ? $grade->grade : 'N/A', 
                'course_instructor_id' => $registration->course_instructor_id,
                'schedule' => $schedule ?? 'N/A',
                'created_at' => $registration->created_at,
                'updated_at' => $registration->updated_at,
            ];
        });
        return response()->json($registrations);
    }
    
    public function getRegisteredStudents($courseInstructorId)
{
    $registrations = Registration::where('course_instructor_id', $courseInstructorId)
        ->with('student.user')
        ->get()
        ->map(function ($registration) {
            $user = $registration->student->user;

            return [
                'student_id' => $registration->student_id,
                'first_name' => $user ? $user->first_name : 'Unknown',
                'middle_name' => $user ? $user->middle_name : 'Unknown',
                'last_name' => $user ? $user->last_name : 'Unknown',
                'email' => $user ? $user->email : 'Unknown',
                'profile_picture' =>  $user ? $user->profile_picture : 'Unknown', 
            ];
        });

    return response()->json($registrations);
}

}

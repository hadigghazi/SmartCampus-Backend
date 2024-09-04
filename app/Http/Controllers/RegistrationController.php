<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Course;
use App\Models\PaymentSetting;
use App\Models\Fee;
use App\Models\Faculty;
use App\Models\Semester;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRegistration;
use App\Http\Requests\UpdateRegistration;

class RegistrationController extends Controller
{
    public function index()
    {
        $items = Registration::get();
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $currentSemester = Semester::where('is_current', true)->first();
        if (!$currentSemester) {
            return response()->json(['error' => 'No current semester found'], 400);
        }
    
        $student = Student::where('user_id', auth()->id())->first();
        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }
    
        $validated = $request->validate([
            'course_instructor_id' => 'required|integer|exists:course_instructors,id',
            'status' => 'sometimes|in:Registered,Completed,Failed',
        ]);
    
        $validated['student_id'] = $student->id;
        $validated['semester_id'] = $currentSemester->id;
        $validated['status'] = $request->input('status', 'Registered');
    
        $registration = Registration::create($validated);
    
        $courseInstructor = $registration->courseInstructor;
        if (!$courseInstructor) {
            $registration->delete();
            return response()->json(['error' => 'Invalid course instructor'], 400);
        }
    
        $course = Course::find($courseInstructor->course_id);
        if (!$course) {
            $registration->delete();
            return response()->json(['error' => 'Invalid course'], 400);
        }
    
        $faculty = Faculty::find($course->faculty_id);
        if (!$faculty) {
            $registration->delete();
            return response()->json(['error' => 'Invalid faculty'], 400);
        }
    
        $paymentSettings = PaymentSetting::latest('effective_date')->first();
        if (!$paymentSettings) {
            $registration->delete();
            return response()->json(['error' => 'Payment settings not found'], 400);
        }
    
        $totalPriceUSD = $faculty->credit_price_usd * $course->credits;
        $totalPriceLBP = $totalPriceUSD * $paymentSettings->lbp_percentage * $paymentSettings->exchange_rate;
    
        $amountUSD = $totalPriceUSD * (1 - $paymentSettings->lbp_percentage);
    
        Fee::create([
            'student_id' => $registration->student_id,
            'course_id' => $course->id,
            'description' => $course->code,
            'amount_usd' => $amountUSD,
            'amount_lbp' => $totalPriceLBP,
            'semester_id' => $currentSemester->id,
        ]);
    
        $existingRegistrationFee = Fee::where('student_id', $registration->student_id)
            ->whereNull('course_id')
            ->where('description', 'Registration Fee')
            ->where('semester_id', $currentSemester->id)
            ->exists();
    
        if (!$existingRegistrationFee) {
            Fee::create([
                'student_id' => $registration->student_id,
                'description' => 'Registration Fee',
                'amount_usd' => $paymentSettings->registration_fee_usd,
                'amount_lbp' => 0,
                'semester_id' => $currentSemester->id,
            ]);
        }
    
        return response()->json($registration, 201);
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
            ->with(['student.user'])
            ->get()
            ->map(function ($registration) {
                $user = $registration->student ? $registration->student->user : null;
    
                return [
                    'student_id' => $registration->student_id,
                    'first_name' => $user ? $user->first_name : 'Unknown',
                    'middle_name' => $user ? $user->middle_name : 'Unknown',
                    'last_name' => $user ? $user->last_name : 'Unknown',
                    'email' => $user ? $user->email : 'Unknown',
                    'profile_picture' => $user ? $user->profile_picture : 'Unknown', 
                ];
            });
    
        return response()->json($registrations);
    }
    
}

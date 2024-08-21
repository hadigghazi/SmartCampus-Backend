<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Http\Requests\StoreMajorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MajorController extends Controller
{
    public function index()
    {
        $majors = Major::get();
        return response()->json($majors);
    }

    public function store(StoreMajorRequest $request)
    {
        $major = Major::create($request->validated());
        return response()->json($major, 201);
    }

    public function show(Major $major)
    {
        return response()->json($major);
    }

    public function update(StoreMajorRequest $request, Major $major)
    {
        $major->update($request->validated());
        return response()->json($major);
    }

    public function destroy(Major $major)
    {
        $major->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $major = Major::withTrashed()->findOrFail($id);
        $major->restore();
        return response()->json($major);
    }

    public function forceDelete($id)
    {
        $major = Major::withTrashed()->findOrFail($id);
        $major->forceDelete();
        return response()->json(null, 204);
    }

    public function getMajorsByFaculty($facultyId)
    {
        $majors = Major::where('faculty_id', $facultyId)->get();
        return response()->json($majors);
    }

    public function suggestMajor(Request $request)
    {
        $request->validate([
            'interests' => 'required|string',
            'skills' => 'required|string',
            'preferences' => 'nullable|string',
        ]);

        $interests = $request->input('interests');
        $skills = $request->input('skills');
        $preferences = $request->input('preferences', '');

        $majors = Major::all()->pluck('name', 'description')->toArray();

        $prompt = "Given the following interests and skills, suggest the most suitable major from the provided list. Explain in details why this major is suitable and what it offers, and the opportunities it opens and so on";
        $prompt .= "Interests: $interests. ";
        $prompt .= "Skills: $skills. ";
        $prompt .= "Preferences: $preferences. ";
        $prompt .= "Majors: " . implode(", ", array_keys($majors)) . ". ";
        $prompt .= "Descriptions: " . implode(", ", array_values($majors)) . ".";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'max_tokens' => 1000,
        ]);

        $suggestion = $response->json()['choices'][0]['message']['content'];

        return response()->json([
            'suggested_major' => $suggestion,
        ]);
    }
}

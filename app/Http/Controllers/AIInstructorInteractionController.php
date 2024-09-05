<?php

namespace App\Http\Controllers;

use App\Models\AIInstructorInteraction;
use App\Http\Requests\StoreAIInstructorInteraction;
use App\Http\Requests\UpdateAIInstructorInteraction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AIInstructorInteractionController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $items = AIInstructorInteraction::where('user_id', $userId)->get();
        return response()->json($items);
    }

    public function store(StoreAIInstructorInteraction $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id(); 
        $item = AIInstructorInteraction::create($data);
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $userId = auth()->id();
        $item = AIInstructorInteraction::withTrashed()->where('user_id', $userId)->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateAIInstructorInteraction $request, $id)
    {
        $userId = auth()->id();
        $item = AIInstructorInteraction::withTrashed()->where('user_id', $userId)->findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $userId = auth()->id();
        $item = AIInstructorInteraction::withTrashed()->where('user_id', $userId)->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $userId = auth()->id();
        $item = AIInstructorInteraction::withTrashed()->where('user_id', $userId)->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $userId = auth()->id();
        $item = AIInstructorInteraction::withTrashed()->where('user_id', $userId)->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }

    public function clear()
    {
        $userId = auth()->id();
        AIInstructorInteraction::where('user_id', $userId)->delete();

        return response()->json(['message' => 'All interactions for the logged-in user have been deleted.']);
    }

    public function chat(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        try {
            $prompt = [
                ['role' => 'system', 'content' => 'You are a helpful assistant. You play the role of instructor in the university.'],
                ['role' => 'user', 'content' => $validated['message']],
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => $prompt,
                'max_tokens' => 1000,
            ]);

            $content = $response->json()['choices'][0]['message']['content'];

            return response()->json([
                'response' => $content,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
}

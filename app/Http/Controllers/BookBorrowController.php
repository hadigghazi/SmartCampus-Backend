<?php

namespace App\Http\Controllers;

use App\Models\BookBorrow;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreBookBorrow;
use App\Http\Requests\UpdateBookBorrow;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BookBorrowController extends Controller
{
    public function index()
    {
        $items = BookBorrow::get();
        return response()->json($items);
    }

    public function store(StoreBookBorrow $request)
    {
        $item = BookBorrow::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = BookBorrow::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateBookBorrow $request, $id)
    {
        $item = BookBorrow::withTrashed()->findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = BookBorrow::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = BookBorrow::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = BookBorrow::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }

    public function indexByBookId($bookId): JsonResponse
    {
        $currentDate = Carbon::now();

    BookBorrow::where('status', 'Borrowed')
        ->where('due_date', '<', $currentDate)
        ->update(['status' => 'Overdue']);

    $bookBorrows = BookBorrow::where('book_id', $bookId)->get();

    return response()->json($bookBorrows);
    }

    public function borrowBook(Request $request): JsonResponse
    {
        $request->validate([
            'book_id' => 'required|integer|exists:library_books,id',
            'due_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->firstOrFail();

        $bookBorrow = BookBorrow::create([
            'book_id' => $request->input('book_id'),
            'student_id' => $student->id,
            'due_date' => $request->input('due_date'),
            'status' => 'Requested',
            'notes' => $request->input('notes'),
        ]);

        return response()->json($bookBorrow, 201);
    }
}

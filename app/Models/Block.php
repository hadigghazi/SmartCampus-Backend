<?php

namespace App\Http\Controllers;

use App\Models\Block;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function index()
    {
        $blocks = Block::withTrashed()->get();
        return response()->json($blocks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'campus_id' => 'required|exists:campuses,id',
            'description' => 'nullable',
        ]);

        $block = Block::create($request->all());

        return response()->json($block, 201);
    }

    public function show(Block $block)
    {
        return response()->json($block);
    }

    public function update(Request $request, Block $block)
    {
        $request->validate([
            'name' => 'required|max:100',
            'campus_id' => 'required|exists:campuses,id',
            'description' => 'nullable',
        ]);

        $block->update($request->all());

        return response()->json($block);
    }

    public function destroy(Block $block)
    {
        $block->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $block = Block::withTrashed()->findOrFail($id);
        $block->restore();

        return response()->json($block);
    }

    public function forceDelete($id)
    {
        $block = Block::withTrashed()->findOrFail($id);
        $block->forceDelete();

        return response()->json(null, 204);
    }
}

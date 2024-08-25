<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Http\Requests\StoreBlockRequest;
use App\Http\Requests\UpdateBlockRequest;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function index()
    {
        $blocks = Block::get();
        return response()->json($blocks);
    }

    public function store(StoreBlockRequest $request)
    {
        $block = Block::create($request->validated());

        return response()->json($block, 201);
    }

    public function show(Block $block)
    {
        return response()->json($block);
    }

    public function update(UpdateBlockRequest $request, Block $block)
    {
        $block->update($request->validated());

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

    public function getBlocksByCampus($campus_id)
{
    $blocks = Block::where('campus_id', $campus_id)->get();
    return response()->json($blocks);
}
}

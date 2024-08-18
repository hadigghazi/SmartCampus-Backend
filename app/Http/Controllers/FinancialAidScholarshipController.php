<?php

namespace App\Http\Controllers;

use App\Models\FinancialAidScholarship;
use App\Http\Requests\StoreFinancialAidScholarship;
use App\Http\Requests\UpdateFinancialAidScholarship;

class FinancialAidScholarshipController extends Controller
{
    public function index()
    {
        $items = FinancialAidScholarship::withTrashed()->get();
        return response()->json($items);
    }

    public function store(StoreFinancialAidScholarship $request)
    {
        $item = FinancialAidScholarship::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = FinancialAidScholarship::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateFinancialAidScholarship $request, $id)
    {
        $item = FinancialAidScholarship::withTrashed()->findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = FinancialAidScholarship::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = FinancialAidScholarship::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = FinancialAidScholarship::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }
}

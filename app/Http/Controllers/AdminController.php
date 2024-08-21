<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::get();
        return response()->json($admins);
    }

    public function store(StoreAdminRequest $request)
    {
        $admin = Admin::create($request->validated());
        return response()->json($admin, 201);
    }

    public function show(Admin $admin)
    {
        return response()->json($admin);
    }

    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $admin->update($request->validated());
        return response()->json($admin);
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $admin = Admin::withTrashed()->findOrFail($id);
        $admin->restore();
        return response()->json($admin);
    }

    public function forceDelete($id)
    {
        $admin = Admin::withTrashed()->findOrFail($id);
        $admin->forceDelete();
        return response()->json(null, 204);
    }
}

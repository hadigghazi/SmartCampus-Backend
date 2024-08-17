<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::withTrashed()->get();
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

}

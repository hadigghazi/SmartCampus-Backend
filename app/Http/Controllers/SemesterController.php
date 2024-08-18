<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::withTrashed()->get();
        return response()->json($addresses);
    }

    public function store(StoreAddressRequest $request)
    {
        $address = Address::create($request->validated());
        return response()->json($address, 201);
    }

    public function show(Address $address)
    {
        return response()->json($address);
    }

    public function update(UpdateAddressRequest $request, Address $address)
    {
        $address->update($request->validated());
        return response()->json($address);
    }

    public function destroy(Address $address)
    {
        $address->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $address = Address::withTrashed()->findOrFail($id);
        $address->restore();
        return response()->json($address);
    }

    public function forceDelete($id)
    {
        $address = Address::withTrashed()->findOrFail($id);
        $address->forceDelete();
        return response()->json(null, 204);
    }
}

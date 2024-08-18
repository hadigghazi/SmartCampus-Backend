<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;

class AddressController extends Controller
{
    public function index()
    {
        return Address::withTrashed()->get();
    }

    public function store(StoreAddressRequest $request)
    {
        $address = Address::create($request->validated());
        return response()->json($address, 201);
    }

}

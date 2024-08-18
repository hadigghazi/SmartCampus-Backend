<?php

namespace App\Http\Controllers;

use App\Models\BusRoute;
use App\Http\Requests\StoreBusRouteRequest;
use App\Http\Requests\UpdateBusRouteRequest;
use Illuminate\Http\Request;

class BusRouteController extends Controller
{
    public function index()
    {
        $busRoutes = BusRoute::withTrashed()->get();
        return response()->json($busRoutes);
    }

    public function store(StoreBusRouteRequest $request)
    {
        $busRoute = BusRoute::create($request->validated());
        return response()->json($busRoute, 201);
    }

    public function show(BusRoute $busRoute)
    {
        return response()->json($busRoute);
    }

    public function update(UpdateBusRouteRequest $request, BusRoute $busRoute)
    {
        $busRoute->update($request->validated());
        return response()->json($busRoute);
    }

    public function destroy(BusRoute $busRoute)
    {
        $busRoute->delete();
        return response()->json(null, 204);
    }

}

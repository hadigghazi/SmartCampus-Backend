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

}

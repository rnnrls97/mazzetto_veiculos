<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\VehicleFuelType;

class VehicleFuelTypeController extends Controller
{
    public function index()
    {
        return Inertia::render('VehicleFuelType/Index', [
            'vehicleFuelType' => VehicleFuelType::all(),
        ]);
    }

    public function create()
    {
        return Inertia::render('VehicleFuelType/Create');
    }

    public function store(Request $request)
    {
        VehicleFuelType::create($request->all());
    }

    public function show(VehicleFuelType $vehicleFuelType)
    {
        return Inertia::render('VehicleFuelType/Show', [
            'vehicleFuelType' => $vehicleFuelType,
        ]);
    }

    public function edit(VehicleFuelType $vehicleFuelType)
    {
        return Inertia::render('VehicleFuelType/Edit', [
            'vehicleFuelType' => $vehicleFuelType,
        ]);
    }

    public function update(Request $request, VehicleFuelType $vehicleFuelType)
    {
        $vehicleFuelType->update($request->all());
    }   

    public function destroy(VehicleFuelType $vehicleFuelType)
    {
        $vehicleFuelType->delete();
    }
}

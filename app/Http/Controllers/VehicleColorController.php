<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\VehicleColor;

class VehicleColorController extends Controller
{
    public function index()
    {
        return Inertia::render('VehicleColors/Index', [
            'vehicleColors' => VehicleColor::all(),
        ]);
    }

    public function create()
    {
        return Inertia::render('VehicleColors/Create');
    }

    public function store(Request $request)
    {
        VehicleColor::create($request->all());
    }

    public function show(VehicleColor $vehicleColor)
    {
        return Inertia::render('VehicleColors/Show', [
            'vehicleColor' => $vehicleColor,
        ]);
    }

    public function edit(VehicleColor $vehicleColor)
    {
        return Inertia::render('VehicleColors/Edit', [
            'vehicleColor' => $vehicleColor,
        ]);
    }

    public function update(Request $request, VehicleColor $vehicleColor)
    {
        $vehicleColor->update($request->all());
    }

    public function destroy(VehicleColor $vehicleColor)
    {
        $vehicleColor->delete();
    }
}
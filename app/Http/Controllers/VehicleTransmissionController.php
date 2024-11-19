<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\VehicleTransmission;

class VehicleTransmissionController extends Controller
{
    public function index()
    {
        return Inertia::render('VehicleTransmissions/Index', [
            'vehicleTransmissions' => VehicleTransmission::all(),
        ]);
    }

    public function create()
    {
        return Inertia::render('VehicleTransmissions/Create');
    }

    public function store(Request $request)
    {
        VehicleTransmission::create($request->all());
    }

    public function show(VehicleTransmission $vehicleTransmission)
    {
        return Inertia::render('VehicleTransmissions/Show', [
            'vehicleTransmission' => $vehicleTransmission,
        ]);
    }

    public function edit(VehicleTransmission $vehicleTransmission)
    {
        return Inertia::render('VehicleTransmissions/Edit', [
            'vehicleTransmission' => $vehicleTransmission,
        ]);
    }

    public function update(Request $request, VehicleTransmission $vehicleTransmission)
    {
        $vehicleTransmission->update($request->all());
    }

    public function destroy(VehicleTransmission $vehicleTransmission)
    {
        $vehicleTransmission->delete();
    }

}
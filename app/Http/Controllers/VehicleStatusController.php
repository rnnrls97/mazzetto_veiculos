<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\VehicleStatus;


class VehicleStatusController extends Controller
{
    public function index()
    {
        return Inertia::render('VehicleStatus/Index', [
            'vehicleStatus' => VehicleStatus::all(),
        ]);
    }

    public function create()
    {
        return Inertia::render('VehicleStatus/Create');
    }

    public function store(Request $request)
    {
        VehicleStatus::create($request->all());
    }

    public function show(VehicleStatus $vehicleStatus)
    {
        return Inertia::render('VehicleStatus/Show', [
            'vehicleStatus' => $vehicleStatus,
        ]);
    }

    public function edit(VehicleStatus $vehicleStatus)
    {
        return Inertia::render('VehicleStatus/Edit', [
            'vehicleStatus' => $vehicleStatus,
        ]);
    }

    public function update(Request $request, VehicleStatus $vehicleStatus)
    {
        $vehicleStatus->update($request->all());
    }

    public function destroy(VehicleStatus $vehicleStatus)
    {
        $vehicleStatus->delete();
    }
}
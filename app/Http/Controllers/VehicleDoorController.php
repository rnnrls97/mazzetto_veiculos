<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\VehicleDoor;

class VehicleDoorController extends Controller
{
    public function index()
    {
        return Inertia::render('VehicleDoors/Index', [
            'vehicleDoors' => VehicleDoor::all(),
        ]);
    }

    public function create()
    {
        return Inertia::render('VehicleDoors/Create');
    }

    public function store(Request $request)
    {
        VehicleDoor::create($request->all());
    }

    public function show(VehicleDoor $vehicleDoor)
    {
        return Inertia::render('VehicleDoors/Show', [
            'vehicleDoor' => $vehicleDoor,
        ]);
    }

    public function edit(VehicleDoor $vehicleDoor)
    {
        return Inertia::render('VehicleDoors/Edit', [
            'vehicleDoor' => $vehicleDoor,
        ]);
    }

    public function update(Request $request, VehicleDoor $vehicleDoor)
    {
        $vehicleDoor->update($request->all());
    }

    public function destroy(VehicleDoor $vehicleDoor)
    {
        $vehicleDoor->delete();
    }
}

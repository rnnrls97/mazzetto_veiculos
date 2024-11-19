<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\VehicleCondition;

class VehicleConditionController extends Controller
{
    public function index()
    {
        return Inertia::render('VehicleConditions/Index', [
            'vehicleConditions' => VehicleCondition::all(),
        ]);
    }

    public function create()
    {
        return Inertia::render('VehicleConditions/Create');
    }

    public function store(Request $request)
    {
        VehicleCondition::create($request->all());
    }

    public function show(VehicleCondition $vehicleCondition)
    {
        return Inertia::render('VehicleConditions/Show', [
            'vehicleCondition' => $vehicleCondition,
        ]);
    }

    public function edit(VehicleCondition $vehicleCondition)
    {
        return Inertia::render('VehicleConditions/Edit', [
            'vehicleCondition' => $vehicleCondition,
        ]);
    }

    public function update(Request $request, VehicleCondition $vehicleCondition)
    {
        $vehicleCondition->update($request->all());
    }

    public function destroy(VehicleCondition $vehicleCondition)
    {
        $vehicleCondition->delete();
    }

}

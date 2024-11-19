<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\VehicleType;
use App\Models\Category;

class VehicleTypeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $vehicleTypes = VehicleType::all();

        return Inertia::render('VehicleType/Index', [
            'categories' => $categories,
            'vehicleType' => $vehicleTypes,
        ]);
    }

    public function create()
    {
        return Inertia::render('VehicleType/Create');
    }

    public function store(Request $request)
    {
        VehicleType::create($request->all());
    }

    public function show(VehicleType $vehicleType)
    {
        return Inertia::render('VehicleType/Show', [
            'vehicleType' => $vehicleType,
        ]);
    }

    public function edit(VehicleType $vehicleType)
    {
        return Inertia::render('VehicleType/Edit', [
            'vehicleType' => $vehicleType,
        ]);
    }

    public function update(Request $request, VehicleType $vehicleType)
    {
        $vehicleType->update($request->all());
    }   

    public function destroy(VehicleType $vehicleType)
    {
        $vehicleType->delete();
    }

}

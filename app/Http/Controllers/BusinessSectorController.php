<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\BusinessSector;

class BusinessSectorController extends Controller
{
    public function index()
    {
        return Inertia::render('BusinessSectors/Index', [
            'businessSectors' => BusinessSector::all(),
        ]);
    }

    public function create()
    {
        return Inertia::render('BusinessSectors/Create');
    }

    public function store(Request $request)
    {
        BusinessSector::create($request->all());
    }

    public function show(BusinessSector $businessSector)
    {
        return Inertia::render('BusinessSectors/Show', [
            'businessSector' => $businessSector,
        ]);
    }

    public function edit(BusinessSector $businessSector)
    {
        return Inertia::render('BusinessSectors/Edit', [
            'businessSector' => $businessSector,
        ]);
    }

    public function update(Request $request, BusinessSector $businessSector)
    {
        $businessSector->update($request->all());
    }

    public function destroy(BusinessSector $businessSector)
    {
        $businessSector->delete();
    }
}


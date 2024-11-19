<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Accessory;

class AccessoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Accessories/Index', [
            'accessories' => Accessory::all(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Accessories/Create');
    }

    public function store(Request $request)
    {
        Accessory::create($request->all());
    }

    public function show(Accessory $accessory)
    {
        return Inertia::render('Accessories/Show', [
            'accessory' => $accessory,
        ]);
    }

    public function edit(Accessory $accessory)
    {
        return Inertia::render('Accessories/Edit', [
            'accessory' => $accessory,
        ]);
    }

    public function update(Request $request, Accessory $accessory)
    {
        $accessory->update($request->all());
    }

    public function destroy(Accessory $accessory)
    {
        $accessory->delete();
    }
}
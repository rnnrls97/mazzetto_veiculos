<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Brand;
use App\Models\BrandModel;

class BrandModelController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        $brandModels = BrandModel::all();

        return Inertia::render('BrandModels/Index', [
            'brands' => $brands,
            'brandModels' => $brandModels,
        ]);
    }

    public function create()
    {
        return Inertia::render('BrandModels/Create');
    }

    public function store(Request $request)
    {
        BrandModel::create($request->all());
    }

    public function show(BrandModel $brandModel)
    {
        return Inertia::render('BrandModels/Show', [
            'brandModel' => $brandModel,
        ]);
    }

    public function edit(BrandModel $brandModel)
    {
        return Inertia::render('BrandModels/Edit', [
            'brandModel' => $brandModel,
        ]);
    }

    public function update(Request $request, BrandModel $brandModel)
    {
        $brandModel->update($request->all());
    }

    public function destroy(BrandModel $brandModel)
    {
        $brandModel->delete();
    }
    
    public function getVersions(BrandModel $brandModel)
    {
        return response()->json($brandModel->versions);
    }
}   

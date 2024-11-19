<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\ModelVersion;
use App\Models\BrandModel;

class BrandModelVersionController extends Controller
{
    public function index()
    {
        $brandModels = BrandModel::all();
        $modelVersions = ModelVersion::all();

        return Inertia::render('ModelVersions/Index', [
            'brandModels' => $brandModels,
            'modelVersions' => $modelVersions,
        ]);
    }

    public function create()
    {
        return Inertia::render('ModelVersions/Create', [
            'brandModels' => BrandModel::all(),
        ]);
    }

    public function store(Request $request)
    {
        ModelVersion::create($request->all());
    }

    public function show(ModelVersion $modelVersion)
    {
        return Inertia::render('ModelVersions/Show', [
            'modelVersion' => $modelVersion,
        ]);
    }

    public function edit(ModelVersion $modelVersion)
    {
        return Inertia::render('ModelVersions/Edit', [
            'modelVersion' => $modelVersion,
            'brandModels' => BrandModel::all(),
        ]);
    }

    public function update(Request $request, ModelVersion $modelVersion)
    {
        $modelVersion->update($request->all());
    }

    public function destroy(ModelVersion $modelVersion)
    {
        $modelVersion->delete();
    }
}
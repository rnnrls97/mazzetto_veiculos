<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Brand;
use App\Services\BrandLogoService;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        return Inertia::render('Brands/Index', [
            'brands' => Brand::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Brands/Create');
    }

    public function store(Request $request)
    {
        $brand = Brand::create($request->all());

        if($request->hasFile('logo')) {
            BrandLogoService::storeLogo($brand, $request);
        }
    }

    public function show(Brand $brand)
    {
        return Inertia::render('Brands/Show', [
            'brand' => $brand,
        ]);
    }

    public function edit(Brand $brand)
    {
        return Inertia::render('Brands/Edit', [
            'brand' => $brand,
        ]);
    }

    public function update(Request $request, Brand $brand)
    {
        $brand->update($request->all());
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
    }

    public function storeLogo(Request $request, Brand $brand)
    {
        if($request->hasFile('logo')) {
            BrandLogoService::storeLogo($brand, $request);
        }
    }
}

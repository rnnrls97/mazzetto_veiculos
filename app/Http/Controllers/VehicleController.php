<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Models\Accessory;
use App\Models\Brand;
use App\Models\BrandModel;
use App\Models\Category;
use App\Models\State;
use App\Models\Vehicle;
use App\Models\VehicleColor;
use App\Models\VehicleCondition;
use App\Models\VehicleDoor;
use App\Models\VehicleFuelType;
use App\Models\VehicleStatus;
use App\Models\VehicleTransmission;
use App\Models\VehicleType;
use App\Services\VehicleImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class VehicleController extends Controller
{
    protected $with = [
        'reseller',
        'brandModel.brand',
        'category',
        'condition',
        'type',
        'fuelType',
        'accessories',
        'state',
        'city',
        'accessories',

    ];

    public function index()
    {
        return Inertia::render('Vehicles/Index', [
            'vehicles' => Vehicle::with($this->with)->get(),
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $brandModels = BrandModel::all();
        $types = VehicleType::all();
        $conditions = VehicleCondition::all();
        $types = VehicleType::all();
        $fuelTypes = VehicleFuelType::all();
        $transmissions = VehicleTransmission::all();
        $colors = VehicleColor::all();
        $doors = VehicleDoor::all();
        $statuses = VehicleStatus::all();
        $states = State::all();
        $accessories = Accessory::all();

        return Inertia::render('Vehicles/Create', [
            'categories' => $categories,
            'brands' => $brands,
            'models' => $brandModels,
            'conditions' => $conditions,
            'types' => $types,
            'fuelTypes' => $fuelTypes,
            'types' => $types,
            'transmissions' => $transmissions,
            'colors' => $colors,
            'doors' => $doors,
            'statuses' => $statuses,
            'states' => $states,
            'accessories' => $accessories,
        ]);
    }

    public function show(Vehicle $vehicle)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $brandModels = BrandModel::all();
        $types = VehicleType::all();
        $conditions = VehicleCondition::all();
        $types = VehicleType::all();
        $fuelTypes = VehicleFuelType::all();
        $transmissions = VehicleTransmission::all();
        $colors = VehicleColor::all();
        $doors = VehicleDoor::all();
        $statuses = VehicleStatus::all();
        $states = State::all();
        $accessories = Accessory::all();

        return Inertia::render('Vehicles/Show', [
            'vehicle' => $vehicle->load([...$this->with, 'images' => fn ($query) => $query->orderBy('order', 'asc')]),
            'categories' => $categories,
            'brands' => $brands,
            'models' => $brandModels,
            'conditions' => $conditions,
            'types' => $types,
            'fuelTypes' => $fuelTypes,
            'types' => $types,
            'transmissions' => $transmissions,
            'colors' => $colors,
            'doors' => $doors,
            'statuses' => $statuses,
            'states' => $states,
            'accessories' => $accessories,
        ]);
    }

    public function store(StoreVehicleRequest $request)
    {
        $vehicle = Vehicle::create($request->validated());

        if ($request->hasFile('images')) {
            $this->storeImages($request, $vehicle);
        }

        if(!empty($request->accessories)) {
            $vehicle->accessories()->sync($request->accessories);
        }
    }

    public function update(UpdateVehicleRequest $request, Vehicle $vehicle)
    {
        $vehicle->update($request->validated());

        if(!empty($request->accessories)) {
            $vehicle->accessories()->sync($request->accessories);
        }
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->images->each(function ($image) {
            Storage::disk('public')->delete($image->image_url);
            $image->delete();
        });
        $vehicle->accessories()->detach();
        $vehicle->delete();
    }

    public function modelos()
    {
        $brands = Brand::with('brandModels.versions')->get();

        return response()->json($brands);
    }

    public function storeImages(Request $request, Vehicle $vehicle)
    {
        VehicleImageService::storeImages($vehicle, $request);
    }
}

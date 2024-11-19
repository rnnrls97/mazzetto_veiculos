<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VehicleTypeController;
use App\Http\Controllers\VehicleFuelTypeController;
use App\Http\Controllers\AccessoryController;
use App\Http\Controllers\BrandModelController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\VehicleImageController;
use App\Http\Controllers\BusinessSectorController;
use App\Http\Controllers\VehicleColorController;
use App\Http\Controllers\VehicleConditionController;
use App\Http\Controllers\VehicleDoorController;
use App\Http\Controllers\VehicleTransmissionController;
use App\Http\Controllers\VehicleStatusController;
use App\Http\Controllers\BrandModelVersionController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::middleware(['guest'])->group(function () {
    Route::get('/', fn() => Inertia::render('auth/login-3', ['title' => 'Login']))->name('login-web');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('home', [HomeController::class, 'index'])->name('home');


    Route::resource('users', UserController::class);
    Route::resource('vehicles', VehicleController::class);
    Route::resource('vehicle-images', VehicleImageController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('vehicleType', VehicleTypeController::class);
    Route::resource('vehicleFuelType', VehicleFuelTypeController::class);
    Route::resource('accessories', AccessoryController::class);
    Route::resource('businessSectors', BusinessSectorController::class);
    Route::resource('vehicleColors', VehicleColorController::class);
    Route::resource('vehicleConditions', VehicleConditionController::class);
    Route::resource('vehicleDoors', VehicleDoorController::class);
    Route::resource('vehicleTransmissions', VehicleTransmissionController::class);
    Route::resource('vehicleStatus', VehicleStatusController::class);
    Route::resource('brandModels', BrandModelController::class);
    Route::resource('modelVersions', BrandModelVersionController::class);

    Route::post('vehicles/{vehicle}/images', [VehicleController::class, 'storeImages'])->name('vehicles.store-images');
    Route::get('brand-models/{brandModel}/versions', [BrandModelController::class, 'getVersions'])->name('brand-models.versions');
    Route::get('states/{state}/cities', [StateController::class, 'getCities'])->name('brand-models.cities');
    Route::get('states', [StateController::class, 'stateCities'])->name('brand-models.cities');
    Route::post('brands/{brand}/logo', [BrandController::class, 'storeLogo'])->name('brands.store-logo');

});

Route::get('/modelos', [VehicleController::class, 'modelos'])->name('modelos');


require __DIR__ . '/auth.php';

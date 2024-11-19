<?php

namespace App\Services;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleImageService
{
    public static function storeImages(Vehicle $vehicle, Request $request): array
    {
        $vehicleImages = [];
        $order = 1;
        $vehicle->images()->delete();

        foreach ($request->file('images') as $image) {
            $path = '/vehicles/' . $vehicle->id . '/' . 'images';

            Storage::disk('public')->put($path, $image);
            
            $vehicleImages[] = $vehicle->images()->create([
                'image_url' => $path . '/' . $image->hashName(),
                'order' => $order,
                'main_image' => $order === 1 ? true : false,
            ]);

            $order++;
        }

        return $vehicleImages;
    }

}

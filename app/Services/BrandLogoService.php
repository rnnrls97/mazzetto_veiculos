<?php

namespace App\Services;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandLogoService
{
    public static function storeLogo(Brand $brand, Request $request): bool
    {
        $path = '/brands';

        Storage::disk('public')->put($path, $request->logo);
        
        return $brand->update([
            'image_url' => $path . '/' . self::normalizeName($brand->name) . '.' . $request->logo->extension(),
        ]);
    }

    public static function normalizeName(string $name): string
    {
        return strtolower(str_replace(' ', '', $name));
    }

}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'reseller_id' => ['required', 'exists:resellers,id'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'vehicle_type_id' => ['required', 'integer', 'exists:vehicle_types,id'],
            'brand_model_id' => ['required', 'integer', 'exists:brand_models,id'],
            'model_version_id' => ['nullable', 'integer', 'exists:model_versions,id'],
            'vehicle_condition_id' => ['required', 'integer', 'exists:vehicle_conditions,id'],
            'vehicle_fuel_type_id' => ['required', 'integer', 'exists:vehicle_fuel_types,id'],
            'vehicle_transmission_id' => ['required', 'integer', 'exists:vehicle_transmissions,id'],
            'vehicle_color_id' => ['required', 'integer', 'exists:vehicle_colors,id'],
            'vehicle_door_id' => ['required', 'integer', 'exists:vehicle_doors,id'],
            'state_id' => ['required', 'integer', 'exists:states,id'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'year' => ['required', 'integer', 'min:1900', 'max:2100'],
            'year_model' => ['required', 'integer', 'min:1900', 'max:2100'],
            'value' => ['required', 'numeric'],
            'highlight' => ['required', 'boolean'],
            'payroll_loan' => ['required', 'boolean'],
            'license_plate' => ['required', 'string'],
            'km_mileage' => ['required', 'integer', 'min:0'],
            'renavam' => ['required', 'string', 'min:9', 'max:11'],
            'observation' => ['nullable', 'string'],
            'active' => ['required', 'boolean'],
            'vehicle_status_id' => ['required', 'integer', 'exists:vehicle_statuses,id'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
    return [
        'name' => 'required|string|max:255',
        'manufacturer' => 'nullable|string|max:255',
        'model' => 'nullable|string|max:255',
        'serial' => 'nullable|string|max:255',
        'type' => 'nullable|string|max:255',
        'location' => 'nullable|string|max:255',
        'inventory_number' => 'nullable|string|max:255',
        'next_inspection' => 'nullable|date',
        'notes' => 'nullable|string',
    ];
    }
}
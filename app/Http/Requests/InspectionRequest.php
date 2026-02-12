<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InspectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'inspection_date' => ['required', 'date'],
            'inspector' => ['required', 'string', 'max:255'],
            'standard' => ['required', 'string', 'max:255'],
            'passed' => ['required', 'boolean'],
            'notes' => ['nullable', 'string'],
            'test_reason' => ['nullable', 'string', 'max:255'],
            'protection_class' => ['nullable', 'string', 'max:255'],
            'tester_device' => ['nullable', 'string', 'max:255'],
            'tester_serial' => ['nullable', 'string', 'max:255'],
            'tester_calibrated_at' => ['nullable', 'date'],
            'interval_months' => ['nullable', 'integer', 'min:1'],
            'test_device_id' => ['nullable', 'exists:test_devices,id'],
        ];
    }
}

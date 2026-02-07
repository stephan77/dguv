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
        ];
    }
}

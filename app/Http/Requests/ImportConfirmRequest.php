<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportConfirmRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'device_ids' => ['array'],
            'device_ids.*' => ['nullable', 'integer', 'exists:devices,id'],
        ];
    }
}

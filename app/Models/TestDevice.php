<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class TestDevice extends Model
{
    protected $fillable = [
        'name',
        'serial_number',
        'calibrated_until',
    ];

    protected $casts = [
        'calibrated_until' => 'date',
    ];

    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }

    public function media(): MorphMany
    {
        return $this->morphMany(DeviceMedia::class, 'mediable')->orderByDesc('is_primary')->orderByDesc('uploaded_at');
    }

    public function primaryMedia(): MorphOne
    {
        return $this->morphOne(DeviceMedia::class, 'mediable')->where('is_primary', true);
    }
}

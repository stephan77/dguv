<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Device extends Model
{
    protected $fillable = [
        'customer_id',
        'name',
        'manufacturer',
        'model',
        'serial',
        'type',
        'location',
        'inventory_number',
        'next_inspection',
        'notes',
    ];

    protected $casts = [
        'next_inspection' => 'date',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(DeviceMedia::class)->orderByDesc('is_primary')->orderByDesc('uploaded_at');
    }

    public function primaryMedia(): HasOne
    {
        return $this->hasOne(DeviceMedia::class)->where('is_primary', true);
    }
}


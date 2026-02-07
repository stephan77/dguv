<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'company',
        'name',
        'email',
        'phone',
        'street',
        'zip',
        'city',
        'notes',
    ];

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }
}

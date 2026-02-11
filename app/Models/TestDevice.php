<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
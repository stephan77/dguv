<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Measurement extends Model
{
    protected $fillable = [
        'inspection_id',
        'test_type',
        'rpe',
        'rpe_result',
        'riso',
        'riso_result',
        'leakage',
        'leakage_result',
        'passed',
        'raw_data',
    ];

    protected $casts = [
        'passed' => 'bool',
        'raw_data' => 'array',
    ];

    public function inspection(): BelongsTo
    {
        return $this->belongsTo(Inspection::class);
    }
}
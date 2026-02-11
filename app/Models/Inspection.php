<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Inspection extends Model
{
    protected $fillable = [
        'device_id',
        'inspection_date',
        'inspector',
        'standard',
        'passed',
        'notes',

        // NEU
        'test_reason',
        'protection_class',
        'tester_device',
        'tester_serial',
        'tester_calibrated_at',
        'interval_months',
        'test_device_id',
    ];

    protected $casts = [
        'inspection_date' => 'date',
        'tester_calibrated_at' => 'date',   // NEU
        'passed' => 'bool',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function measurements(): HasMany
    {
        return $this->hasMany(Measurement::class);
    }
    public function tester()
{
    return $this->belongsTo(TestDevice::class, 'test_device_id');
}

}

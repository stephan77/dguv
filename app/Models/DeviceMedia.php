<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class DeviceMedia extends Model
{
    protected $table = 'device_media';

    protected $fillable = [
        'device_id',
        'file_path',
        'thumbnail_path',
        'file_type',
        'is_primary',
        'uploaded_at',
        'uploaded_by',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'uploaded_at' => 'datetime',
    ];

    protected $appends = [
        'file_url',
        'thumbnail_url',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getFileUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->file_path);
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->thumbnail_path === null) {
            return null;
        }

        return Storage::disk('public')->url($this->thumbnail_path);
    }
}

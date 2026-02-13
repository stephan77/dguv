<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Device;
use App\Models\DeviceMedia;
use Illuminate\Http\UploadedFile;

class DeviceMediaService
{
    public function __construct(private readonly MediaService $mediaService)
    {
    }

    public function storeUploadedFile(Device $device, UploadedFile $file, ?int $userId): DeviceMedia
    {
        return $this->mediaService->storeUploadedFile($device, $file, $userId);
    }

    public function setPrimary(Device $device, DeviceMedia $media): void
    {
        $this->mediaService->setPrimary($device, $media);
    }

    public function delete(Device $device, DeviceMedia $media): void
    {
        $this->mediaService->delete($device, $media);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceMedia;
use App\Services\DeviceMediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RuntimeException;

class DeviceMediaController extends Controller
{
    public function index(Device $device): JsonResponse
    {
        $media = $device->media()->get();

        return response()->json(['data' => $media]);
    }

    public function store(Request $request, Device $device, DeviceMediaService $mediaService): JsonResponse
    {
        $validated = $request->validate([
            'files' => ['required', 'array', 'min:1'],
            'files.*' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,webp,mp4,webm',
                'mimetypes:image/jpeg,image/png,image/webp,video/mp4,video/webm',
                'max:51200',
            ],
        ]);

        $stored = [];
        foreach ($validated['files'] as $file) {
            $stored[] = $mediaService->storeUploadedFile($device, $file, auth()->id());
        }

        return response()->json(['data' => $stored], 201);
    }

    public function setPrimary(Device $device, DeviceMedia $media, DeviceMediaService $mediaService): JsonResponse
    {
        try {
            $mediaService->setPrimary($device, $media);
        } catch (RuntimeException $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }

        return response()->json(['status' => 'ok']);
    }

    public function destroy(Device $device, DeviceMedia $media, DeviceMediaService $mediaService): JsonResponse
    {
        try {
            $mediaService->delete($device, $media);
        } catch (RuntimeException $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }

        return response()->json(['status' => 'ok']);
    }
}

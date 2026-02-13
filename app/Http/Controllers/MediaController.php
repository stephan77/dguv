<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceMedia;
use App\Models\TestDevice;
use App\Services\MediaService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RuntimeException;

class MediaController extends Controller
{
    public function deviceIndex(Device $device): JsonResponse
    {
        return $this->index($device);
    }

    public function deviceStore(Request $request, Device $device, MediaService $mediaService): JsonResponse
    {
        return $this->store($request, $device, $mediaService);
    }

    public function deviceSetPrimary(Device $device, DeviceMedia $media, MediaService $mediaService): JsonResponse
    {
        return $this->setPrimary($device, $media, $mediaService);
    }

    public function deviceDestroy(Device $device, DeviceMedia $media, MediaService $mediaService): JsonResponse
    {
        return $this->destroy($device, $media, $mediaService);
    }

    public function testDeviceIndex(TestDevice $testDevice): JsonResponse
    {
        return $this->index($testDevice);
    }

    public function testDeviceStore(Request $request, TestDevice $testDevice, MediaService $mediaService): JsonResponse
    {
        return $this->store($request, $testDevice, $mediaService);
    }

    public function testDeviceSetPrimary(TestDevice $testDevice, DeviceMedia $media, MediaService $mediaService): JsonResponse
    {
        return $this->setPrimary($testDevice, $media, $mediaService);
    }

    public function testDeviceDestroy(TestDevice $testDevice, DeviceMedia $media, MediaService $mediaService): JsonResponse
    {
        return $this->destroy($testDevice, $media, $mediaService);
    }

    private function index(Model $mediable): JsonResponse
    {
        return response()->json(['data' => $mediable->media()->get()]);
    }

    private function store(Request $request, Model $mediable, MediaService $mediaService): JsonResponse
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
            $stored[] = $mediaService->storeUploadedFile($mediable, $file, auth()->id());
        }

        return response()->json(['data' => $stored], 201);
    }

    private function setPrimary(Model $mediable, DeviceMedia $media, MediaService $mediaService): JsonResponse
    {
        try {
            $mediaService->setPrimary($mediable, $media);
        } catch (RuntimeException $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }

        return response()->json(['status' => 'ok']);
    }

    private function destroy(Model $mediable, DeviceMedia $media, MediaService $mediaService): JsonResponse
    {
        try {
            $mediaService->delete($mediable, $media);
        } catch (RuntimeException $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }

        return response()->json(['status' => 'ok']);
    }
}

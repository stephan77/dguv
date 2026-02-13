<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\DeviceMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class MediaService
{
    public function storeUploadedFile(Model $mediable, UploadedFile $file, ?int $userId): DeviceMedia
    {
        $mime = $file->getMimeType() ?? '';
        $isImage = str_starts_with($mime, 'image/');
        $fileType = $isImage ? 'image' : 'video';

        $directory = sprintf('device-media/%s/%d', class_basename($mediable), $mediable->getKey());
        $filePath = $file->store($directory, 'public');
        $thumbnailPath = $isImage ? $this->createThumbnail($file, $directory) : null;

        return DB::transaction(function () use ($mediable, $filePath, $thumbnailPath, $fileType, $userId): DeviceMedia {
            $hasPrimary = $mediable->media()->where('is_primary', true)->exists();

            return $mediable->media()->create([
                'file_path' => $filePath,
                'thumbnail_path' => $thumbnailPath,
                'file_type' => $fileType,
                'is_primary' => $fileType === 'image' && ! $hasPrimary,
                'uploaded_by' => $userId,
                'uploaded_at' => now(),
            ]);
        });
    }

    public function setPrimary(Model $mediable, DeviceMedia $media): void
    {
        if (! $this->belongsToModel($mediable, $media) || $media->file_type !== 'image') {
            throw new RuntimeException('Ungültiges Hauptbild.');
        }

        DB::transaction(function () use ($mediable, $media): void {
            $mediable->media()->where('is_primary', true)->update(['is_primary' => false]);
            $media->update(['is_primary' => true]);
        });
    }

    public function delete(Model $mediable, DeviceMedia $media): void
    {
        if (! $this->belongsToModel($mediable, $media)) {
            throw new RuntimeException('Medium gehört nicht zum Eintrag.');
        }

        $wasPrimary = $media->is_primary;

        Storage::disk('public')->delete([$media->file_path, $media->thumbnail_path]);
        $media->delete();

        if ($wasPrimary) {
            $nextImage = $mediable->media()->where('file_type', 'image')->latest('uploaded_at')->first();
            if ($nextImage !== null) {
                $nextImage->update(['is_primary' => true]);
            }
        }
    }

    private function belongsToModel(Model $mediable, DeviceMedia $media): bool
    {
        return $media->mediable_type === $mediable::class
            && (int) $media->mediable_id === (int) $mediable->getKey();
    }

    private function createThumbnail(UploadedFile $file, string $directory): ?string
    {
        if (! function_exists('imagecreatefromstring') || ! function_exists('imagewebp')) {
            return null;
        }

        $binary = file_get_contents($file->getRealPath());
        if ($binary === false) {
            return null;
        }

        $source = @imagecreatefromstring($binary);
        if (! $source) {
            return null;
        }

        $width = imagesx($source);
        $height = imagesy($source);
        $side = min($width, $height);
        $srcX = (int) floor(($width - $side) / 2);
        $srcY = (int) floor(($height - $side) / 2);

        $thumb = imagecreatetruecolor(320, 320);
        imagecopyresampled($thumb, $source, 0, 0, $srcX, $srcY, 320, 320, $side, $side);

        $thumbnailPath = sprintf('%s/thumb_%s.webp', $directory, uniqid('', true));

        ob_start();
        imagewebp($thumb, null, 80);
        $content = ob_get_clean();

        imagedestroy($thumb);
        imagedestroy($source);

        if (! is_string($content)) {
            return null;
        }

        Storage::disk('public')->put($thumbnailPath, $content);

        return $thumbnailPath;
    }
}

<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Device;
use App\Models\DeviceMedia;
use App\Models\TestDevice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DeviceMediaTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_upload_multiple_media_files_for_device(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $device = $this->createDevice();

        $response = $this->actingAs($user)->post(route('devices.media.store', $device), [
            'files' => [
                UploadedFile::fake()->image('first.jpg'),
                UploadedFile::fake()->create('movie.mp4', 500, 'video/mp4'),
            ],
        ]);

        $response->assertCreated()->assertJsonCount(2, 'data');
        $this->assertDatabaseCount('device_media', 2);
        $this->assertDatabaseHas('device_media', [
            'mediable_id' => $device->id,
            'mediable_type' => Device::class,
        ]);
    }

    public function test_user_can_upload_media_for_test_device_and_set_primary(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $testDevice = TestDevice::create([
            'name' => 'Benning ST725',
            'serial_number' => 'ST-1234',
        ]);

        $this->actingAs($user)->post(route('test-devices.media.store', $testDevice), [
            'files' => [
                UploadedFile::fake()->image('first.jpg'),
                UploadedFile::fake()->image('second.jpg'),
            ],
        ])->assertCreated();

        $media = DeviceMedia::where('mediable_type', TestDevice::class)->where('mediable_id', $testDevice->id)->get();
        $this->assertCount(2, $media);

        $target = $media->last();
        $this->actingAs($user)
            ->patch(route('test-devices.media.primary', [$testDevice, $target]))
            ->assertOk();

        $this->assertTrue($target->fresh()->is_primary);
    }

    public function test_primary_image_can_be_set_for_device(): void
    {
        $user = User::factory()->create();
        $device = $this->createDevice();

        $first = DeviceMedia::create([
            'device_id' => $device->id,
            'mediable_id' => $device->id,
            'mediable_type' => Device::class,
            'file_path' => 'a.jpg',
            'file_type' => 'image',
            'is_primary' => true,
            'uploaded_at' => now(),
        ]);

        $second = DeviceMedia::create([
            'device_id' => $device->id,
            'mediable_id' => $device->id,
            'mediable_type' => Device::class,
            'file_path' => 'b.jpg',
            'file_type' => 'image',
            'is_primary' => false,
            'uploaded_at' => now(),
        ]);

        $this->actingAs($user)
            ->patch(route('devices.media.primary', [$device, $second]))
            ->assertOk();

        $this->assertFalse($first->fresh()->is_primary);
        $this->assertTrue($second->fresh()->is_primary);
    }

    public function test_customer_show_renders_primary_media_icon(): void
    {
        $user = User::factory()->create();
        $device = $this->createDevice();

        DeviceMedia::create([
            'device_id' => $device->id,
            'mediable_id' => $device->id,
            'mediable_type' => Device::class,
            'file_path' => 'device-media/1/main.jpg',
            'thumbnail_path' => 'device-media/1/thumb.webp',
            'file_type' => 'image',
            'is_primary' => true,
            'uploaded_at' => now(),
        ]);

        $this->actingAs($user)
            ->get(route('customers.show', $device->customer))
            ->assertOk()
            ->assertSee('Hauptbild');
    }

    private function createDevice(): Device
    {
        $customer = Customer::create([
            'company' => 'Test GmbH',
            'name' => 'Max Mustermann',
            'email' => 'test@example.com',
            'phone' => '123456',
            'street' => 'Musterstraße 1',
            'zip' => '12345',
            'city' => 'Berlin',
        ]);

        return Device::create([
            'customer_id' => $customer->id,
            'name' => 'Prüfgerät',
            'inventory_number' => 'INV-001',
        ]);
    }
}

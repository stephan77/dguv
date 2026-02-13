<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Device;
use App\Models\DeviceMedia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DeviceMediaTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_upload_multiple_media_files(): void
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
    }

    public function test_primary_image_can_be_set(): void
    {
        $user = User::factory()->create();
        $device = $this->createDevice();

        $first = DeviceMedia::create([
            'device_id' => $device->id,
            'file_path' => 'a.jpg',
            'file_type' => 'image',
            'is_primary' => true,
            'uploaded_at' => now(),
        ]);

        $second = DeviceMedia::create([
            'device_id' => $device->id,
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

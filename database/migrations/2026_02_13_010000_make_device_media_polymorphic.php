<?php

declare(strict_types=1);

use App\Models\Device;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('device_media', function (Blueprint $table): void {
            $table->unsignedBigInteger('mediable_id')->nullable()->after('device_id');
            $table->string('mediable_type')->nullable()->after('mediable_id');
            $table->foreignId('device_id')->nullable()->change();
            $table->index(['mediable_type', 'mediable_id', 'uploaded_at'], 'device_media_mediable_uploaded_at_idx');
        });

        DB::table('device_media')
            ->whereNotNull('device_id')
            ->update([
                'mediable_id' => DB::raw('device_id'),
                'mediable_type' => Device::class,
            ]);
    }

    public function down(): void
    {
        DB::table('device_media')
            ->where('mediable_type', Device::class)
            ->update(['device_id' => DB::raw('mediable_id')]);

        Schema::table('device_media', function (Blueprint $table): void {
            $table->dropIndex('device_media_mediable_uploaded_at_idx');
            $table->dropColumn(['mediable_id', 'mediable_type']);
        });
    }
};

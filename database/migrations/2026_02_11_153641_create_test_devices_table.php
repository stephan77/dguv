<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
Schema::create('test_devices', function (Blueprint $table) {
    $table->id();
    $table->string('name');              // BENNING ST725
    $table->string('manufacturer')->nullable();
    $table->string('serial_number');     // wichtig!
    $table->date('calibrated_at')->nullable();
    $table->date('calibrated_until')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_devices');
    }
};

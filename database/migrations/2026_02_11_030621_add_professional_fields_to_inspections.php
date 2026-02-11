<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inspections', function (Blueprint $table) {
            $table->string('test_reason')->nullable();       
            $table->string('protection_class')->nullable();  
            $table->string('tester_device')->nullable();     
            $table->string('tester_serial')->nullable();
            $table->date('tester_calibrated_at')->nullable();
            $table->integer('interval_months')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('inspections', function (Blueprint $table) {
            $table->dropColumn([
                'test_reason',
                'protection_class',
                'tester_device',
                'tester_serial',
                'tester_calibrated_at',
                'interval_months'
            ]);
        });
    }
};

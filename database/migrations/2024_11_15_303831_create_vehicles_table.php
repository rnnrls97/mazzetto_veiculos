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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reseller_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('vehicle_type_id')->constrained();
            $table->foreignId('brand_model_id')->constrained();
            $table->foreignId('model_version_id')->nullable()->constrained();
            $table->foreignId('vehicle_condition_id')->constrained();
            $table->foreignId('vehicle_fuel_type_id')->constrained();
            $table->foreignId('vehicle_transmission_id')->constrained();
            $table->foreignId('vehicle_color_id')->constrained();
            $table->foreignId('vehicle_door_id')->constrained();
            $table->foreignId('state_id')->constrained();
            $table->foreignId('city_id')->constrained();
            $table->unsignedInteger('year');
            $table->unsignedInteger('year_model');
            $table->decimal('value', 15, 4);
            $table->boolean('highlight')->default(false);
            $table->boolean('payroll_loan')->default(false);
            $table->string('license_plate', 20);
            $table->unsignedInteger('km_mileage');
            $table->string('renavam', 60);
            $table->unsignedInteger('views')->default(0);
            $table->text('observation')->nullable();
            $table->boolean('active')->default(true);
            $table->foreignId('vehicle_status_id')->constrained();
            $table->date('sale_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};

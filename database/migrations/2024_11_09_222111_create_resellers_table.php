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
        Schema::create('resellers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('address_id', 6)->nullabe()->constrained();
            $table->string('company_name', 255);
            $table->string('trade_name', 150);
            $table->string('contact', 30);
            $table->string('phone1', 15);
            $table->string('phone2', 15)->nullable();
            $table->string('email', 60);
            $table->string('website', 200)->nullable();
            $table->text('notes')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('head_office')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resellers');
    }
};

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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_type_id')->constrained();
            $table->foreignId('reseller_id')->nullable()->constrained();
            $table->foreignId('business_sector_id')->nullable()->constrained();
            $table->foreignId('address_id')->constrained();
            $table->dateTime('registration_date');
            $table->string('company_name', 255);
            $table->string('trade_name', 150);
            $table->string('contact', 100);
            $table->string('cnpj_cpf', 14);
            $table->string('state_registration', 20);
            $table->string('phone1', 15);
            $table->string('phone2', 15)->nullable();
            $table->string('email', 60);
            $table->string('website', 120)->nullable();
            $table->string('observation')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('direct_mail')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};

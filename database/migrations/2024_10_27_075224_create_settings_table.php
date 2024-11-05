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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->default('Pro-B Accounting');
            $table->string('company_name');
            $table->string('company_logo')->nullable();
            $table->string('company_phone');
            $table->string('company_email')->nullable();
            $table->string('company_street');
            $table->string('company_city_and_province');
            $table->string('company_country');
            $table->foreignId('currency_id')->constrained();
            $table->string('thousand_separator');
            $table->string('decimal_separator');
            $table->string('locale_string');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};

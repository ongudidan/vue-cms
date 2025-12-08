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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('primary_phone');
            $table->string('secondary_phone')->nullable();
            $table->string('country');
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('website')->nullable();
            $table->text('physical_address')->nullable();
            $table->string('postal_address')->nullable();
            $table->string('tax_identification_pin')->nullable();
            $table->string('logo')->nullable();
            $table->string('footer_logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('x_profile')->nullable();
            $table->string('fb_profile')->nullable();
            $table->string('ig_profile')->nullable();
            $table->string('tiktok_profile')->nullable();
            $table->string('pinterest_profile')->nullable();
            $table->string('youtube_profile')->nullable();
            $table->boolean('has_footer_logo')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};

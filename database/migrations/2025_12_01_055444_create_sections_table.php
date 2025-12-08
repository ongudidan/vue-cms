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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->string('type')->nullable();
            $table->string('sub_title')->nullable();
            $table->string('title')->nullable();
            $table->longText('details')->nullable();
            $table->string('component_type')->nullable();
            $table->tinyInteger('order')->default(0);
            $table->boolean('include_contact_cards')->default(false);
            $table->boolean('section_has_image')->default(false);
            $table->boolean('section_image_first')->default(false);
            $table->boolean('has_cta_buttons')->default(false);
            $table->boolean('section_has_map')->default(false);
            $table->boolean('sliding_hero_section')->default(false);
            $table->boolean('section_has_bg')->default(false);
            $table->string('section_background_type')->nullable();
            $table->string('section_background_color')->nullable();
            $table->string('section_style')->nullable();
            $table->longText('map_link')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('page_id')->references('id')->on('pages');

            $table->index('page_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};

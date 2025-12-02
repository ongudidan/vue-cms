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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id')->nullable();
            $table->string('title');
            $table->string('type');     // e.g page, custom, service
            $table->string('url')->nullable();
            $table->boolean('has_children')->default(false);
            $table->string('child_type')->nullable();
            $table->string('component')->nullable();
            $table->integer('parent_id')->default(-1)->index(); // Must default to -1!
            $table->integer('order')->default(0);

            $table->foreign('page_id')->references('id')->on('pages');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};

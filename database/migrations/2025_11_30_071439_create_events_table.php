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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('hosted_by')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->json('images')->nullable();
            $table->json('tags')->nullable();
            $table->date('date');
            $table->text('location')->nullable();
            $table->text('map_url')->nullable();
            $table->longText('details');
            $table->boolean('active')->default(true);

            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

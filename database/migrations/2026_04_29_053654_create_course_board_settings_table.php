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
        Schema::create('course_board_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('trimestre', 2);
            $table->text('nee_students')->nullable();
            $table->json('dece_options')->nullable();
            $table->json('behavior_options')->nullable();
            $table->json('resolution_options')->nullable();
            $table->timestamps();

            $table->unique(['course_id', 'trimestre']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_board_settings');
    }
};

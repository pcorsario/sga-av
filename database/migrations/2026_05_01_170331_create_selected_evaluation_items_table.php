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
        Schema::create('selected_evaluation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_subject_id')->constrained('course_subjects')->cascadeOnDelete();
            $table->foreignId('evaluation_item_id')->constrained('evaluation_items')->cascadeOnDelete();
            $table->string('quarter'); // q1, q2, q3, diagnostic
            $table->timestamps();

            $table->unique(['course_subject_id', 'evaluation_item_id', 'quarter'], 'unique_selection');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selected_evaluation_items');
    }
};

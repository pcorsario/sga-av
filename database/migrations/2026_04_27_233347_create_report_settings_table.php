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
        Schema::create('report_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_subject_id')->constrained()->cascadeOnDelete();
            $table->string('trimestre', 50); // t1, t2, t3, diagnostic
            $table->integer('destrezas_planificadas')->default(0);
            $table->integer('destrezas_logradas')->default(0);
            $table->json('causas')->nullable();
            $table->json('medidas')->nullable();
            $table->json('recomendaciones')->nullable();
            $table->timestamps();

            $table->unique(['course_subject_id', 'trimestre']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_settings');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('insumo_names');

        Schema::create('insumo_names', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_subject_id')->constrained()->cascadeOnDelete();
            $table->string('trimester', 10);

            for ($i = 1; $i <= 6; $i++) {
                $table->string("ind_{$i}", 100)->nullable();
            }

            for ($i = 1; $i <= 6; $i++) {
                $table->string("grp_{$i}", 100)->nullable();
            }

            for ($i = 1; $i <= 2; $i++) {
                $table->string("ref_{$i}", 100)->nullable();
            }

            $table->string('proj', 100)->nullable();
            $table->string('eval', 100)->nullable();

            $table->timestamps();

            $table->unique(['course_subject_id', 'trimester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insumo_names');

        Schema::create('insumo_names', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_subject_id')->constrained()->cascadeOnDelete();
            $table->enum('trimester', ['t1', 't2', 't3']);

            for ($i = 1; $i <= 6; $i++) {
                $table->string("ind_{$i}", 100)->nullable();
            }

            for ($i = 1; $i <= 6; $i++) {
                $table->string("grp_{$i}", 100)->nullable();
            }

            for ($i = 1; $i <= 2; $i++) {
                $table->string("ref_{$i}", 100)->nullable();
            }

            $table->string('proj', 100)->nullable();
            $table->string('eval', 100)->nullable();

            $table->timestamps();

            $table->unique(['course_subject_id', 'trimester']);
        });
    }
};

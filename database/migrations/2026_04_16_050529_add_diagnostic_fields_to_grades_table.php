<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            for ($i = 1; $i <= 6; $i++) {
                $table->decimal("diag_ind_{$i}", 5, 2)->nullable();
            }

            for ($i = 1; $i <= 6; $i++) {
                $table->decimal("diag_grp_{$i}", 5, 2)->nullable();
            }

            for ($i = 1; $i <= 2; $i++) {
                $table->decimal("diag_ref_{$i}", 5, 2)->nullable();
            }

            $table->decimal('diag_proj', 5, 2)->nullable();
            $table->decimal('diag_eval', 5, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            for ($i = 1; $i <= 6; $i++) {
                $table->dropColumn("diag_ind_{$i}");
            }

            for ($i = 1; $i <= 6; $i++) {
                $table->dropColumn("diag_grp_{$i}");
            }

            for ($i = 1; $i <= 2; $i++) {
                $table->dropColumn("diag_ref_{$i}");
            }

            $table->dropColumn('diag_proj');
            $table->dropColumn('diag_eval');
        });
    }
};

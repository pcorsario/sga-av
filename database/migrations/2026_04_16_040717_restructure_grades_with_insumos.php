<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $trimesters = ['t1', 't2', 't3'];

            foreach ($trimesters as $t) {
                for ($i = 1; $i <= 6; $i++) {
                    $table->decimal("{$t}_ind_{$i}", 5, 2)->nullable();
                }

                for ($i = 1; $i <= 6; $i++) {
                    $table->decimal("{$t}_grp_{$i}", 5, 2)->nullable();
                }

                for ($i = 1; $i <= 2; $i++) {
                    $table->decimal("{$t}_ref_{$i}", 5, 2)->nullable();
                }

                $table->decimal("{$t}_proj", 5, 2)->nullable();
                $table->decimal("{$t}_eval", 5, 2)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $trimesters = ['t1', 't2', 't3'];

            foreach ($trimesters as $t) {
                for ($i = 1; $i <= 6; $i++) {
                    $table->dropColumn("{$t}_ind_{$i}");
                }

                for ($i = 1; $i <= 6; $i++) {
                    $table->dropColumn("{$t}_grp_{$i}");
                }

                for ($i = 1; $i <= 2; $i++) {
                    $table->dropColumn("{$t}_ref_{$i}");
                }

                $table->dropColumn("{$t}_proj");
                $table->dropColumn("{$t}_eval");
            }
        });
    }
};

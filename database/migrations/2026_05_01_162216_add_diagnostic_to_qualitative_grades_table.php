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
        Schema::table('qualitative_grades', function (Blueprint $table) {
            $table->boolean('diagnostic_grade')->nullable()->after('evaluation_item_id');
            $table->text('diagnostic_observation')->nullable()->after('q3_observation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('qualitative_grades', function (Blueprint $table) {
            $table->dropColumn(['diagnostic_grade', 'diagnostic_observation']);
        });
    }
};

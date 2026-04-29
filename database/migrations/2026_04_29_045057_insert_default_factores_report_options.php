<?php

use App\Models\ReportOption;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE report_options MODIFY COLUMN type ENUM('causa', 'medida', 'recomendacion', 'factor')");

        $factores = [
            'Interrupciones por actividades institucionales',
            'Limitación en el tiempo de práctica pedagógica',
            'Insuficiente sistematización de los refuerzos académicos',
            'Diversidad en los ritmos y estilos de aprendizaje',
            'Limitaciones en recursos didácticos y pedagógicos',
            'Ausentismo y asistencia irregular de los estudiantes',
            'Carga académica elevada en el periodo',
            'Tiempo reducido para evaluación formativa',
            'Factores socioemocionales y de motivación',
            'Limitaciones en el acompañamiento familiar',
        ];

        foreach ($factores as $factor) {
            ReportOption::create([
                'type' => 'factor',
                'category' => 'General',
                'description' => $factor,
                'is_default' => true,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        ReportOption::where('type', 'factor')->delete();
    }
};

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
        DB::statement("ALTER TABLE report_options MODIFY COLUMN type ENUM('causa', 'medida', 'recomendacion', 'factor', 'dece', 'comportamiento', 'resolucion')");

        $options = [
            'dece' => [
                'Se da lectura al informe del DECE con los reportes de estudiantes derivados.',
                'Se analiza la situación socioemocional y familiar de los estudiantes reportados.',
                'Se acuerda dar seguimiento a los estudiantes con acompañamiento psicológico.',
            ],
            'comportamiento' => [
                'El curso obtiene una calificación de B, es decir cumple SATISFACTORIAMENTE.',
                'El curso obtiene una calificación de C, es decir POCO SATISFACTORIAMENTE.',
                'En el ámbito comportamental no existieron inconvenientes como para sancionar en calificaciones.',
                'Se registran casos de indisciplina que han sido derivados a inspección.',
            ],
            'resolucion' => [
                'Citar y notificar a los representantes legales de los estudiantes que tienen asignaturas con calificaciones menores a 7, firmar actas de compromiso.',
                'Trabajar los contenidos con metodologías activas, adaptaciones curriculares y procesos evaluativos permanentes.',
                'Aplicar herramientas que desarrollen un buen clima áulico que permitan instaurar disciplina como medio de un buen desarrollo académico.',
                'En las evaluaciones formativas, utilizar los respectivos instrumentos de evaluación (listas de cotejo, guías de observación, rúbricas).',
                'En el caso que los estudiantes estén SE, realizar el oficio de solicitud dirigido al señor rector adjuntando los justificativos.',
                'Notificar al padre de familia las inasistencias de sus representados y realizar el proceso respectivo.',
            ],
        ];

        foreach ($options as $type => $texts) {
            foreach ($texts as $text) {
                ReportOption::create([
                    'type' => $type,
                    'category' => 'General',
                    'description' => $text,
                    'is_default' => true,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        ReportOption::whereIn('type', ['dece', 'comportamiento', 'resolucion'])->delete();
        DB::statement("ALTER TABLE report_options MODIFY COLUMN type ENUM('causa', 'medida', 'recomendacion', 'factor')");
    }
};

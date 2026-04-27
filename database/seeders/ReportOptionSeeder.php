<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = [
            // CAUSAS - 🧠 Factores cognitivos
            ['type' => 'causa', 'category' => '🧠 Factores cognitivos', 'description' => 'Dificultades de atención o concentración.', 'is_default' => true],
            ['type' => 'causa', 'category' => '🧠 Factores cognitivos', 'description' => 'Problemas de memoria (olvidos frecuentes).', 'is_default' => false],
            ['type' => 'causa', 'category' => '🧠 Factores cognitivos', 'description' => 'Aparentes problemas de memoria.', 'is_default' => true],
            ['type' => 'causa', 'category' => '🧠 Factores cognitivos', 'description' => 'Dificultades en la comprensión de conceptos básicos.', 'is_default' => true],
            ['type' => 'causa', 'category' => '🧠 Factores cognitivos', 'description' => 'Ritmo de aprendizaje más lento que el promedio.', 'is_default' => false],
            ['type' => 'causa', 'category' => '🧠 Factores cognitivos', 'description' => 'Problemas en habilidades básicas (lectura, escritura o cálculo).', 'is_default' => false],
            ['type' => 'causa', 'category' => '🧠 Factores cognitivos', 'description' => 'Posibles trastornos del aprendizaje (como dislexia o discalculia).', 'is_default' => false],
            
            // CAUSAS - 💭 Factores emocionales y motivacionales
            ['type' => 'causa', 'category' => '💭 Factores emocionales y motivacionales', 'description' => 'Desinterés o falta de motivación por el estudio.', 'is_default' => false],
            ['type' => 'causa', 'category' => '💭 Factores emocionales y motivacionales', 'description' => 'Desinterés por el estudio.', 'is_default' => true],
            ['type' => 'causa', 'category' => '💭 Factores emocionales y motivacionales', 'description' => 'Baja autoestima académica (“cree que no puede aprender”).', 'is_default' => false],
            ['type' => 'causa', 'category' => '💭 Factores emocionales y motivacionales', 'description' => 'Ansiedad, estrés o presión excesiva.', 'is_default' => false],
            ['type' => 'causa', 'category' => '💭 Factores emocionales y motivacionales', 'description' => 'Desánimo o frustración constante.', 'is_default' => false],
            ['type' => 'causa', 'category' => '💭 Factores emocionales y motivacionales', 'description' => 'Falta de metas o propósito claro en los estudios.', 'is_default' => false],
            
            // CAUSAS - 🏫 Factores escolares
            ['type' => 'causa', 'category' => '🏫 Factores escolares', 'description' => 'Problemas con los compañeros de clase.', 'is_default' => true],
            ['type' => 'causa', 'category' => '🏫 Factores escolares', 'description' => 'Problemas con los compañeros de clase (conflictos, bullying).', 'is_default' => false],
            ['type' => 'causa', 'category' => '🏫 Factores escolares', 'description' => 'Dificultades en la relación con docentes.', 'is_default' => false],
            ['type' => 'causa', 'category' => '🏫 Factores escolares', 'description' => 'Falta de participación en clase.', 'is_default' => false],
            ['type' => 'causa', 'category' => '🏫 Factores escolares', 'description' => 'No presentan actividades, tareas o deberes.', 'is_default' => false],
            ['type' => 'causa', 'category' => '🏫 Factores escolares', 'description' => 'No presentan actividades, deberes.', 'is_default' => true],
            ['type' => 'causa', 'category' => '🏫 Factores escolares', 'description' => 'Ausencias frecuentes o impuntualidad.', 'is_default' => false],
            ['type' => 'causa', 'category' => '🏫 Factores escolares', 'description' => 'Métodos de enseñanza poco adecuados para el estudiante.', 'is_default' => false],

            // CAUSAS - 🏠 Factores familiares y sociales
            ['type' => 'causa', 'category' => '🏠 Factores familiares y sociales', 'description' => 'Poco apoyo o seguimiento en casa.', 'is_default' => false],
            ['type' => 'causa', 'category' => '🏠 Factores familiares y sociales', 'description' => 'Problemas familiares (conflictos, cambios importantes).', 'is_default' => false],
            ['type' => 'causa', 'category' => '🏠 Factores familiares y sociales', 'description' => 'Falta de hábitos de estudio en el hogar.', 'is_default' => false],
            ['type' => 'causa', 'category' => '🏠 Factores familiares y sociales', 'description' => 'Exceso de responsabilidades fuera del colegio.', 'is_default' => false],
            ['type' => 'causa', 'category' => '🏠 Factores familiares y sociales', 'description' => 'Ambiente poco adecuado para estudiar (ruido, distracciones).', 'is_default' => false],

            // CAUSAS - 📱 Hábitos y estilo de vida
            ['type' => 'causa', 'category' => '📱 Hábitos y estilo de vida', 'description' => 'Uso excesivo de celular, redes sociales o videojuegos.', 'is_default' => false],
            ['type' => 'causa', 'category' => '📱 Hábitos y estilo de vida', 'description' => 'Falta de organización del tiempo.', 'is_default' => false],
            ['type' => 'causa', 'category' => '📱 Hábitos y estilo de vida', 'description' => 'Malos hábitos de estudio (estudia sin planificación).', 'is_default' => false],
            ['type' => 'causa', 'category' => '📱 Hábitos y estilo de vida', 'description' => 'Pocas horas de sueño o cansancio constante.', 'is_default' => false],
            ['type' => 'causa', 'category' => '📱 Hábitos y estilo de vida', 'description' => 'Alimentación inadecuada o falta de actividad física.', 'is_default' => false],

            // CAUSAS - 🧩 Otros posibles factores
            ['type' => 'causa', 'category' => '🧩 Otros posibles factores', 'description' => 'Problemas de salud (visión, audición, etc.).', 'is_default' => false],
            ['type' => 'causa', 'category' => '🧩 Otros posibles factores', 'description' => 'Cambios recientes (mudanza, cambio de escuela).', 'is_default' => false],
            ['type' => 'causa', 'category' => '🧩 Otros posibles factores', 'description' => 'Falta de orientación académica o vocacional.', 'is_default' => false],


            // MEDIDAS ADOPTADAS
            ['type' => 'medida', 'category' => '📚 MEDIDAS ADOPTADAS POR EL/LA DOCENTE', 'description' => 'Organizar actividades individuales y grupales que fomenten la participación activa, el trabajo colaborativo y el intercambio de conocimientos entre los estudiantes.', 'is_default' => false],
            ['type' => 'medida', 'category' => '📚 MEDIDAS ADOPTADAS POR EL/LA DOCENTE', 'description' => 'Organizar actividades individuales y en grupo que requieran la colaboración y el intercambio de conocimientos entre estudiantes.', 'is_default' => true],
            ['type' => 'medida', 'category' => '📚 MEDIDAS ADOPTADAS POR EL/LA DOCENTE', 'description' => 'Aplicar evaluaciones formativas de manera permanente, con el fin de monitorear el progreso académico y realizar ajustes oportunos en las estrategias de enseñanza.', 'is_default' => false],
            ['type' => 'medida', 'category' => '📚 MEDIDAS ADOPTADAS POR EL/LA DOCENTE', 'description' => 'Implementar evaluaciones formativas permanentes para verificar el progreso de los estudiantes y ajustar las estrategias de enseñanza según sea necesario.', 'is_default' => true],
            ['type' => 'medida', 'category' => '📚 MEDIDAS ADOPTADAS POR EL/LA DOCENTE', 'description' => 'Mantener una comunicación abierta, constante y efectiva con los docentes tutores, padres de familia o representantes legales, informando sobre el desempeño y las necesidades del estudiante.', 'is_default' => false],
            ['type' => 'medida', 'category' => '📚 MEDIDAS ADOPTADAS POR EL/LA DOCENTE', 'description' => 'Mantener una comunicación abierta y constante con los docentes tutores y padres de familia o representantes legales.', 'is_default' => true],
            ['type' => 'medida', 'category' => '📚 MEDIDAS ADOPTADAS POR EL/LA DOCENTE', 'description' => 'Proporcionar retroalimentación oportuna, clara y constructiva sobre las actividades realizadas, resaltando los logros alcanzados y orientando sobre las áreas que requieren mejora.', 'is_default' => false],
            ['type' => 'medida', 'category' => '📚 MEDIDAS ADOPTADAS POR EL/LA DOCENTE', 'description' => 'Proporcionar retroalimentación oportuna de las actividades realizadas por los estudiantes, destacando los logros y las áreas en las que puede mejorar.', 'is_default' => true],
            ['type' => 'medida', 'category' => '📚 MEDIDAS ADOPTADAS POR EL/LA DOCENTE', 'description' => 'Brindar oportunidades de recuperación y mejora de calificaciones, tanto en evaluaciones formativas como sumativas, de acuerdo con lo establecido en el Modelo Institucional de Evaluación Educativa (MIEE).', 'is_default' => false],
            ['type' => 'medida', 'category' => '📚 MEDIDAS ADOPTADAS POR EL/LA DOCENTE', 'description' => 'Brindar oportunidades para mejorar las calificaciones, tanto de evaluaciones formativas como sumativas, acorde a lo determinado en el modelo institucional de evaluación educativa (MIEE).', 'is_default' => true],

            ['type' => 'medida', 'category' => '✏️ Otras medidas complementarias recomendadas', 'description' => 'Adaptar estrategias metodológicas según el ritmo y estilo de aprendizaje de los estudiantes.', 'is_default' => false],
            ['type' => 'medida', 'category' => '✏️ Otras medidas complementarias recomendadas', 'description' => 'Reforzar contenidos básicos mediante actividades de nivelación o refuerzo académico.', 'is_default' => false],
            ['type' => 'medida', 'category' => '✏️ Otras medidas complementarias recomendadas', 'description' => 'Utilizar recursos didácticos variados (material visual, digital, práctico) para facilitar la comprensión.', 'is_default' => false],
            ['type' => 'medida', 'category' => '✏️ Otras medidas complementarias recomendadas', 'description' => 'Establecer normas claras y rutinas de trabajo dentro del aula.', 'is_default' => false],
            ['type' => 'medida', 'category' => '✏️ Otras medidas complementarias recomendadas', 'description' => 'Promover hábitos de estudio y organización del tiempo.', 'is_default' => false],
            ['type' => 'medida', 'category' => '✏️ Otras medidas complementarias recomendadas', 'description' => 'Incentivar la participación mediante preguntas, dinámicas y actividades motivadoras.', 'is_default' => false],
            ['type' => 'medida', 'category' => '✏️ Otras medidas complementarias recomendadas', 'description' => 'Realizar seguimiento individual a estudiantes con mayores dificultades.', 'is_default' => false],


            // RECOMENDACIONES
            ['type' => 'recomendacion', 'category' => '📖 RECOMENDACIONES PARA PROMOVER EL APRENDIZAJE', 'description' => 'Fomentar la participación activa de los estudiantes en las actividades de clase, incentivando la formulación de preguntas, el análisis de ejemplos prácticos y la aplicación de los conocimientos adquiridos en diferentes contextos.', 'is_default' => false],
            ['type' => 'recomendacion', 'category' => '📖 RECOMENDACIONES PARA PROMOVER EL APRENDIZAJE', 'description' => 'Que los estudiantes se involucren en las actividades de clase, realizar preguntas, buscar ejemplos prácticos y aplicar los conocimientos adquiridos.', 'is_default' => true],
            ['type' => 'recomendacion', 'category' => '📖 RECOMENDACIONES PARA PROMOVER EL APRENDIZAJE', 'description' => 'Promover en el hogar el uso de diversas técnicas de estudio, como la visualización de videos educativos, elaboración de gráficos, resúmenes, esquemas y mapas conceptuales, con el fin de fortalecer la comprensión de los contenidos.', 'is_default' => false],
            ['type' => 'recomendacion', 'category' => '📖 RECOMENDACIONES PARA PROMOVER EL APRENDIZAJE', 'description' => 'En casa utilizar diferentes técnicas de estudio, como videos, gráficos, resúmenes y mapas conceptuales, para enriquecer la comprensión.', 'is_default' => true],
            ['type' => 'recomendacion', 'category' => '📖 RECOMENDACIONES PARA PROMOVER EL APRENDIZAJE', 'description' => 'Motivar a los estudiantes a aprovechar todas las oportunidades para la entrega de actividades, así como los procesos de recuperación y mejoramiento de calificaciones.', 'is_default' => false],
            ['type' => 'recomendacion', 'category' => '📖 RECOMENDACIONES PARA PROMOVER EL APRENDIZAJE', 'description' => 'Aprovechar las oportunidades para presentar actividades y mejoramiento de calificaciones.', 'is_default' => true],
            ['type' => 'recomendacion', 'category' => '📖 RECOMENDACIONES PARA PROMOVER EL APRENDIZAJE', 'description' => 'Desarrollar actividades prácticas que involucren el diseño y aplicación de conocimientos en situaciones reales, favoreciendo el aprendizaje significativo.', 'is_default' => false],
            ['type' => 'recomendacion', 'category' => '📖 RECOMENDACIONES PARA PROMOVER EL APRENDIZAJE', 'description' => 'Realizar actividades prácticas que se involucren el diseño de aplicaciones en entornos reales.', 'is_default' => true],

            ['type' => 'recomendacion', 'category' => '✏️ Otras recomendaciones complementarias', 'description' => 'Establecer horarios de estudio organizados y constantes.', 'is_default' => false],
            ['type' => 'recomendacion', 'category' => '✏️ Otras recomendaciones complementarias', 'description' => 'Crear un ambiente adecuado para el aprendizaje, libre de distracciones.', 'is_default' => false],
            ['type' => 'recomendacion', 'category' => '✏️ Otras recomendaciones complementarias', 'description' => 'Reforzar hábitos de lectura y comprensión.', 'is_default' => false],
            ['type' => 'recomendacion', 'category' => '✏️ Otras recomendaciones complementarias', 'description' => 'Utilizar recursos tecnológicos de manera responsable como apoyo educativo.', 'is_default' => false],
            ['type' => 'recomendacion', 'category' => '✏️ Otras recomendaciones complementarias', 'description' => 'Solicitar ayuda al docente cuando existan dudas o dificultades.', 'is_default' => false],
            ['type' => 'recomendacion', 'category' => '✏️ Otras recomendaciones complementarias', 'description' => 'Trabajar en equipo para fortalecer el aprendizaje colaborativo.', 'is_default' => false],
            ['type' => 'recomendacion', 'category' => '✏️ Otras recomendaciones complementarias', 'description' => 'Practicar de manera continua los contenidos vistos en clase.', 'is_default' => false],
        ];

        foreach ($options as $option) {
            \App\Models\ReportOption::create($option);
        }
    }
}

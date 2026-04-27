<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe de Progreso</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            margin: -20px 0 0 0;
            padding: 0;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: middle;
        }

        .header-container {
            width: 100%;
            margin-bottom: 0;
            border: 1px solid #000;
            border-bottom: none;
            display: table;
        }

        .logo {
            width: 60px;
            margin: 5px;
        }

        .text-center {
            text-align: center;
        }

        .text-bold {
            font-weight: bold;
        }

        .section-title {
            background-color: #f0f0f0;
            font-weight: bold;
            text-transform: uppercase;
            padding: 4px;
            font-size: 11px;
        }

        .info-table td {
            font-size: 10px;
        }

        ul {
            margin: 0;
            padding-left: 20px;
        }

        li {
            margin-bottom: 3px;
        }

        .page-break {
            page-break-before: always;
        }

        .signatures-table {
            text-align: center;
            margin-top: 10px;
        }

        .signatures-table td {
            height: 60px;
            vertical-align: bottom;
            padding-bottom: 5px;
        }

        .signatures-header td {
            font-weight: bold;
            background-color: #f0f0f0;
            height: auto;
            vertical-align: middle;
        }
    </style>
</head>
<body>

    <!-- CABECERA -->
    <table style="border-bottom: none;">
        <tr>
            <td style="width: 15%; text-align: center; border-right: none;">
                @if(file_exists(public_path('logo.png')))
                    <img src="{{ public_path('logo.png') }}" alt="Logo" class="logo">
                @else
                    <div style="width:60px; height:60px; border:1px solid #ccc; border-radius:50%; display:inline-block; line-height:60px;">LOGO</div>
                @endif
            </td>
            <td style="width: 70%; text-align: center; border-left: none; border-right: none;">
                <div class="text-bold" style="font-size: 14px;">UNIDAD EDUCATIVA "ALESSANDRO VOLTA"</div>
                <div style="font-size: 9px; margin-top: 3px;">Dirección: Coop. Santa Martha Sect. 3. Av. Jacinto Cortez Jhayya y Los Quinches</div>
                <div style="font-size: 9px;">Teléfonos: 3704-269 / 3704-554 / 3704-123 E-mail: col_volta@yahoo.com</div>
                <div style="font-size: 9px;">Santo Domingo – Ecuador</div>
            </td>
            <td style="width: 15%; text-align: center; font-weight: bold;">
                AÑO LECTIVO<br>
                {{ date('Y') }} - {{ date('Y', strtotime('+1 year')) }}
            </td>
        </tr>
        <tr>
            <td colspan="3" class="text-center text-bold" style="font-size: 12px; background-color: #f0f0f0;">
                INFORME DE PROGRESO
            </td>
        </tr>
    </table>

    <!-- 1. DATOS INFORMATIVOS -->
    <div class="section-title" style="border: 1px solid #000; border-top: none;">1. DATOS INFORMATIVOS:</div>
    <table class="info-table" style="border-top: none;">
        <tr>
            <td style="width: 33%;">NIVEL/SUBNIVEL: <span class="text-bold">{{ $courseSubject->course->level }}</span></td>
            <td style="width: 33%;">SECCIÓN: <span class="text-bold">Matutina</span></td>
            <td style="width: 34%;">TRIMESTRE: <span class="text-bold">{{ str_replace(' Trimestre', '', $trimestreName) }}</span></td>
        </tr>
        <tr>
            <td>CURSO: <span class="text-bold">{{ preg_replace('/[A-Z]$/', '', $courseSubject->course->name) }}</span></td>
            <td>PARALELO: <span class="text-bold">{{ substr($courseSubject->course->name, -1) }}</span></td>
            <td>N° ESTUDIANTES: <span class="text-bold">{{ count($students) }}</span></td>
        </tr>
        <tr>
            <td>FIGURA PROFESIONAL: <span class="text-bold">Informática</span></td>
            <td colspan="2">ASIGNATURA: <span class="text-bold">{{ $courseSubject->subject->name }}</span></td>
        </tr>
        <tr>
            <td colspan="3">DOCENTE: <span class="text-bold">{{ $teacherName }}</span></td>
        </tr>
    </table>

    <!-- 2. AVANCE ACADÉMICO -->
    <div class="section-title" style="border: 1px solid #000; border-top: none;">2. AVANCE ACADÉMICO:</div>
    <table style="border-top: none; width: 80%; margin: 0 auto; margin-top: 10px; margin-bottom: 10px;">
        <tr>
            <td style="width: 70%;">N° DE DESTREZAS PLANIFICADAS:</td>
            <td class="text-center">4</td>
        </tr>
        <tr>
            <td>N° DE DESTREZAS LOGRADAS:</td>
            <td class="text-center">3</td>
        </tr>
        <tr>
            <td>% DE DESTREZAS LOGRADAS:</td>
            <td class="text-center">75%</td>
        </tr>
        <tr>
            <td colspan="2" class="text-center" style="background-color: #f8f9fa;">FACTORES QUE NO PERMITIERON EL 100% DE DESARROLLO DE DESTREZAS:</td>
        </tr>
        <tr>
            <td colspan="2" class="text-center text-bold">Actividades institucionales por lo general los días que se tiene con el curso</td>
        </tr>
    </table>

    <!-- 3. RESULTADOS DE LOS APRENDIZAJES -->
    <div class="section-title" style="border: 1px solid #000; border-top: none; border-bottom: none;">3. RESULTADOS DE LOS APRENDIZAJES ALCANZADOS POR LOS ESTUDIANTES:</div>
    <table style="width: 80%; margin: 0 auto; margin-top: 10px; margin-bottom: 10px;">
        <thead>
            <tr class="text-center">
                <th>ESCALA CUALITATIVA</th>
                <th>EQUIVALENCIA</th>
                <th>N°<br>ESTUDIANTES</th>
                <th>%</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Domina los aprendizajes</td>
                <td class="text-center">9.00 - 10.00</td>
                <td class="text-center">{{ $stats['DA']['count'] }}</td>
                <td class="text-center">{{ number_format($stats['DA']['percentage'], 2) }}</td>
            </tr>
            <tr>
                <td>Alcanza los aprendizajes</td>
                <td class="text-center">7.00 - 8.99</td>
                <td class="text-center">{{ $stats['AA']['count'] }}</td>
                <td class="text-center">{{ number_format($stats['AA']['percentage'], 2) }}</td>
            </tr>
            <tr>
                <td>Está próximo a alcanzar los aprendizajes</td>
                <td class="text-center">4.01 - 6.99</td>
                <td class="text-center">{{ $stats['PA']['count'] }}</td>
                <td class="text-center">{{ number_format($stats['PA']['percentage'], 2) }}</td>
            </tr>
            <tr>
                <td>No alcanza los aprendizajes</td>
                <td class="text-center"><= 4</td>
                <td class="text-center">{{ $stats['NA']['count'] }}</td>
                <td class="text-center">{{ number_format($stats['NA']['percentage'], 2) }}</td>
            </tr>
            <tr>
                <td colspan="2" class="text-center text-bold" style="background-color: #f8f9fa;">PROMEDIO DEL CURSO:</td>
                <td colspan="2" class="text-center text-bold">{{ number_format($stats['media'], 2) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- 4. PROMEDIOS TRIMESTRALES -->
    <div class="section-title" style="border: 1px solid #000; border-top: none; border-bottom: none;">4. PROMEDIOS TRIMESTRALES.</div>
    <table style="font-size: 10px;">
        <thead>
            <tr class="text-center" style="background-color: #f8f9fa;">
                <th style="width: 5%;">N°</th>
                <th style="width: 40%;">NÓMINA ESTUDIANTES</th>
                <th style="width: 13%;">PROMEDIO<br>TRIMESTRAL<br>>=7</th>
                <th style="width: 13%;">PROMEDIO<br>< 7</th>
                <th style="width: 14%;">SIN EXAMEN<br>SE</th>
                <th style="width: 15%;">SIN<br>CALIFICACIÓN<br>SC</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $student)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $student['name'] }}</td>
                <td class="text-center">{{ (!$student['sin_calificacion'] && $student['promedio_parcial'] >= 7) ? number_format($student['promedio_parcial'], 2) : '' }}</td>
                <td class="text-center">{{ (!$student['sin_calificacion'] && $student['promedio_parcial'] < 7) ? number_format($student['promedio_parcial'], 2) : '' }}</td>
                <td class="text-center">{{ $student['sin_examen'] ? 'X' : '' }}</td>
                <td class="text-center">{{ $student['sin_calificacion'] ? 'X' : '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- 5. CAUSAS -->
    <div class="section-title" style="border: 1px solid #000; border-top: none;">4. CAUSAS O DIFICULTADES PARA EL BAJO RENDIMIENTO:</div>
    <div style="border: 1px solid #000; border-top: none; padding: 5px;">
        <ul>
            <li>Dificultades de atención o concentración.</li>
            <li>Desinterés por el estudio.</li>
            <li>Dificultades de comprensión de conceptos básicos.</li>
            <li>Aparentes problemas de memoria.</li>
            <li>Problemas con los compañeros de clase.</li>
            <li>No presentan actividades, deberes.</li>
        </ul>
    </div>

    <!-- 6. MEDIDAS ADOPTADAS -->
    <div class="section-title" style="border: 1px solid #000; border-top: none;">5. MEDIDAS ADOPTADAS POR EL/LA DOCENTE:</div>
    <div style="border: 1px solid #000; border-top: none; padding: 5px; text-align: justify;">
        Para mejorar el rendimiento académico y consecuentemente las calificaciones, se ha utilizado diferentes estrategias, entre las cuales tenemos:
        <ul style="margin-top: 5px;">
            <li>Organizar actividades individuales y en grupo que requieran la colaboración y el intercambio de conocimientos entre estudiantes.</li>
            <li>Implementar evaluaciones formativas permanentes para verificar el progreso de los estudiantes y ajustar las estrategias de enseñanza según sea necesario.</li>
            <li>Mantener una comunicación abierta y constante con los docentes tutores y padres de familia o representantes legales.</li>
            <li>Proporcionar retroalimentación oportuna de las actividades realizadas por los estudiantes, destacando los logros y las áreas en las que puede mejorar.</li>
            <li>Brindar oportunidades para mejorar las calificaciones, tanto de evaluaciones formativas como sumativas, acorde a lo determinado en el modelo institucional de evaluación educativa (MIEE).</li>
        </ul>
    </div>

    <!-- 7. RECOMENDACIONES -->
    <div class="section-title" style="border: 1px solid #000; border-top: none;">6. RECOMENDACIONES PARA PROMOVER EL APRENDIZAJE:</div>
    <div style="border: 1px solid #000; border-top: none; padding: 5px; text-align: justify;">
        <ul>
            <li>Que los estudiantes se involucren en las actividades de clase, realizar preguntas, buscar ejemplos prácticos y aplicar los conocimientos adquiridos.</li>
            <li>En casa utilizar diferentes técnicas de estudio, como videos, gráficos, resúmenes y mapas conceptuales, para enriquecer la comprensión.</li>
            <li>Aprovechar las oportunidades para presentar actividades y mejoramiento de calificaciones.</li>
            <li>Realizar actividades prácticas que se involucren el diseño de aplicaciones en entornos reales.</li>
        </ul>
    </div>

    <!-- 8. CONCLUSIONES -->
    <div class="section-title" style="border: 1px solid #000; border-top: none;">7. CONCLUSIONES:</div>
    <div style="border: 1px solid #000; border-top: none; padding: 15px; text-align: justify;">
        <ul>
            <li>
                De acuerdo a las nóminas enviadas por secretaria constan <b>{{ count($students) }} estudiantes</b>, de los cuales 
                <b>{{ $stats['mayor_7'] }} mantienen una calificación mayor o igual a 7,00</b> y 
                <b>{{ $stats['menor_7'] }} presentan calificaciones menores a 7,00</b>.
            </li>
        </ul>
    </div>

    <!-- FIRMAS -->
    <table class="signatures-table" style="border-top: none;">
        <tr class="signatures-header">
            <td style="width: 25%;">ELABORADO: Docente.</td>
            <td style="width: 25%;">RECIBIDO: Tutor/a.</td>
            <td style="width: 50%;" colspan="2">Revisado por Vicerrectorado.</td>
        </tr>
        <tr>
            <td style="text-align: left; vertical-align: top;">{{ $teacherName }}</td>
            <td style="text-align: left; vertical-align: top;">{{ $tutorName }}</td>
            <td style="text-align: center; vertical-align: top;">Mgt. Diana Celi</td>
            <td style="text-align: center; vertical-align: top;">Dr. Carlos Arévalo</td>
        </tr>
        <tr>
            <td>Fecha: {{ date('d/m/Y') }}</td>
            <td>Fecha: {{ date('d/m/Y') }}</td>
            <td colspan="2">Fecha: {{ date('d/m/Y') }}</td>
        </tr>
    </table>

</body>
</html>

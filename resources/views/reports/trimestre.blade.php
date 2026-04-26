<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe Trimestral de Aprendizaje</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
        }
        
        .header-table {
            width: 100%;
            margin-bottom: 10px;
            text-align: center;
        }

        .header-table td {
            vertical-align: middle;
        }

        .logo {
            width: 70px;
        }

        .header-title {
            font-size: 14px;
            font-weight: bold;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 10px;
        }

        .info-table td {
            padding: 2px 5px;
        }

        .info-label {
            font-weight: bold;
        }

        .grades-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        .grades-table th, .grades-table td {
            border: 1px solid #000;
            padding: 2px;
        }

        .grades-table th {
            background-color: #f8f9fa;
        }

        .rotate {
            white-space: nowrap;
            /* In DOMPDF, rotated text can be tricky, we try an image replacement or specific rules if it fails, but CSS transforms often work in modern dompdf versions if enabled, or we just write them compactly */
            /* However, best dompdf workaround for rotation is usually just small text or wrapping. But let's try CSS3 rotate if supported, or inline block. */
        }

        .vertical-text-container {
            width: 20px;
            height: 120px; /* fixed height for headers */
            position: relative;
        }

        .vertical-text {
            position: absolute;
            transform: rotate(-90deg);
            transform-origin: bottom left;
            left: 15px;
            top: 110px;
            white-space: nowrap;
            font-size: 9px;
            width: 120px;
            text-align: left;
        }

        .student-name {
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }

        .signatures {
            width: 100%;
            margin-top: 40px;
            text-align: center;
        }

        .signature-line {
            width: 200px;
            border-top: 1px solid #000;
            margin: 0 auto 5px auto;
        }

        .stats-table {
            width: 60%;
            margin: 30px auto 0 auto;
            border-collapse: collapse;
            text-align: center;
        }

        .stats-table th, .stats-table td {
            border: 1px solid #000;
            padding: 3px;
        }

        .stats-table th {
            background-color: #f8f9fa;
        }

        .text-bold {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td style="width: 15%; text-align: left;">
                @if(file_exists(public_path('logo.png')))
                    <img src="{{ public_path('logo.png') }}" alt="Logo" class="logo">
                @else
                    <div style="width:70px; height:70px; border:1px solid #ccc; border-radius:50%; display:inline-block; line-height:70px;">LOGO</div>
                @endif
            </td>
            <td style="width: 70%;">
                <div class="header-title">UNIDAD EDUCATIVA "ALESSANDRO VOLTA"</div>
                <div class="header-title" style="margin-top: 5px;">INFORME DEL {{ strtoupper($trimestreName) }} DE APRENDIZAJE</div>
            </td>
            <td style="width: 15%;"></td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <td style="width: 20%;" class="info-label">1 ÁREA Y/O ASIGNATURA:</td>
            <td style="width: 30%;">{{ $courseSubject->subject->name }}</td>
            <td style="width: 20%;" class="info-label">4 ESPECIALIZACIÓN:</td>
            <td style="width: 30%;">N/A</td>
        </tr>
        <tr>
            <td class="info-label">2 GRADO O CURSO:</td>
            <td>{{ $courseSubject->course->name }}</td>
            <td class="info-label">5 AÑO LECTIVO:</td>
            <td>{{ date('Y') }} - {{ date('Y', strtotime('+1 year')) }}</td>
        </tr>
        <tr>
            <td class="info-label">3 PROFESOR/A:</td>
            <td>{{ $teacherName }}</td>
            <td class="info-label">6 FECHA:</td>
            <td>{{ date('d/m/y') }}</td>
        </tr>
    </table>

    <table class="grades-table">
        <thead>
            <tr>
                <th rowspan="2" style="width: 3%;">Nº</th>
                <th rowspan="2" style="width: 35%;">NÓMINA</th>
                <th colspan="2">Evaluación Formativa</th>
                <th colspan="2">Proyecto Integrador</th>
                <th colspan="2">Evaluación Sumativa</th>
                <th rowspan="2" style="width: 7%;">
                    <div class="vertical-text-container">
                        <div class="vertical-text">PROMEDIO PARCIAL</div>
                    </div>
                </th>
                <th rowspan="2" style="width: 15%;">Escala Cualitativa</th>
            </tr>
            <tr>
                <!-- Evaluacion Formativa -->
                <th style="width: 5%;">
                    <div class="vertical-text-container">
                        <div class="vertical-text">PROMEDIO ACTIVIDADES</div>
                    </div>
                </th>
                <th style="width: 5%;">
                    <div class="vertical-text-container">
                        <div class="vertical-text">70% ACTIVIDADES</div>
                    </div>
                </th>
                <!-- Proyecto Integrador -->
                <th style="width: 5%;">
                    <div class="vertical-text-container">
                        <div class="vertical-text">INGRESE NOTA PROYECTO</div>
                    </div>
                </th>
                <th style="width: 5%;">
                    <div class="vertical-text-container">
                        <div class="vertical-text">10% PROYECTO</div>
                    </div>
                </th>
                <!-- Evaluacion Sumativa -->
                <th style="width: 5%;">
                    <div class="vertical-text-container">
                        <div class="vertical-text">INGRESE NOTA EVALUACIÓN</div>
                    </div>
                </th>
                <th style="width: 5%;">
                    <div class="vertical-text-container">
                        <div class="vertical-text">20% EVALUACIÓN</div>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $student)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="student-name">{{ $student['name'] }}</td>
                <td>{{ number_format($student['promedio_actividades'], 2) }}</td>
                <td>{{ number_format($student['actividades_70'], 2) }}</td>
                <td>{{ number_format($student['nota_proyecto'], 2) }}</td>
                <td>{{ number_format($student['proyecto_10'], 2) }}</td>
                <td>{{ number_format($student['nota_evaluacion'], 2) }}</td>
                <td>{{ number_format($student['evaluacion_20'], 2) }}</td>
                <td class="text-bold">{{ number_format($student['promedio_parcial'], 2) }}</td>
                <td>{{ $student['escala'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="signatures">
        <tr>
            <td style="width: 50%;">
                <div class="signature-line"></div>
                <div>{{ $teacherName }}</div>
                <div class="text-bold">Docente</div>
            </td>
            <td style="width: 50%;">
                <div class="signature-line"></div>
                <div>{{ $tutorName }}</div>
                <div class="text-bold">Tutor</div>
            </td>
        </tr>
    </table>

    <table class="stats-table">
        <thead>
            <tr>
                <th colspan="3">CUADRO DE PORCENTUALIZACIÓN</th>
            </tr>
            <tr>
                <th>Escala cualitativa</th>
                <th>Número de estudiantes</th>
                <th>Porcentaje de estudiantes</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: left;">Domina los aprendizajes (DA) 9 a 10</td>
                <td>{{ $stats['DA']['count'] }}</td>
                <td>{{ number_format($stats['DA']['percentage'], 2) }}</td>
            </tr>
            <tr>
                <td style="text-align: left;">Alcanza los aprendizajes (AA) 7 a 8.99</td>
                <td>{{ $stats['AA']['count'] }}</td>
                <td>{{ number_format($stats['AA']['percentage'], 2) }}</td>
            </tr>
            <tr>
                <td style="text-align: left;">Esta próximo a alcanzar (PA) 4.01-6.99</td>
                <td>{{ $stats['PA']['count'] }}</td>
                <td>{{ number_format($stats['PA']['percentage'], 2) }}</td>
            </tr>
            <tr>
                <td style="text-align: left;">No alcanza (NA) <= 4</td>
                <td>{{ $stats['NA']['count'] }}</td>
                <td>{{ number_format($stats['NA']['percentage'], 2) }}</td>
            </tr>
            <tr>
                <td class="text-bold">TOTAL</td>
                <td class="text-bold">{{ $stats['total'] }}</td>
                <td class="text-bold">MEDIA X<br>{{ number_format($stats['media'], 2) }}</td>
            </tr>
        </tbody>
    </table>

</body>
</html>

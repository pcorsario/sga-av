<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tabulación Pruebas de Diagnóstico</title>
    <style>
        @page {
            margin: 0.8cm;
            size: portrait;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 6.5pt;
            color: #1a1a1a;
            line-height: 1.1;
        }
        .header {
            width: 100%;
            margin-bottom: 8px;
            text-align: center;
        }
        .institution-name {
            font-size: 11pt;
            font-weight: bold;
            color: #6d28d9;
            text-transform: uppercase;
        }
        .report-title {
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #4c1d95;
        }
        
        .meta-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .meta-table td { border: 0.5px solid #ddd6fe; padding: 2px 5px; }
        .meta-label { background-color: #f5f3ff; width: 15%; text-transform: uppercase; font-size: 5.5pt; color: #5b21b6; font-weight: bold; }

        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th, .data-table td { border: 0.5px solid #ddd6fe; padding: 2px 1px; text-align: center; }
        .data-table th { background-color: #f5f3ff; font-weight: bold; text-transform: uppercase; font-size: 5pt; color: #5b21b6; }
        .student-name { text-align: left !important; padding-left: 3px !important; font-size: 5.2pt; }

        .charts-container { width: 100%; margin-top: 15px; }
        .chart-wrapper {
            display: inline-block;
            width: 48%;
            vertical-align: top;
            text-align: center;
            border: 0.5px solid #ede9fe;
            border-radius: 8px;
            padding: 15px 0;
            height: 140px;
        }
        .chart-title {
            font-weight: bold;
            font-size: 7pt;
            color: #4c1d95;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        /* Pie Chart Container */
        .pie-box {
            position: relative;
            height: 80px;
            width: 80px;
            margin: 0 auto;
        }
        .pie-image {
            width: 80px;
            height: 80px;
        }
        .pie-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            margin-top: -5px;
            font-size: 11pt;
            font-weight: bold;
            color: #4c1d95;
        }

        /* Bar Chart */
        .bar-area {
            height: 60px;
            width: 85%;
            margin: 25px auto 0;
            border-bottom: 0.5px solid #ddd6fe;
            position: relative;
        }
        .bar-col {
            display: inline-block;
            width: 10%;
            height: 100%;
            position: relative;
            margin: 0 10%;
        }
        .bar-fill {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            border-radius: 2px 2px 0 0;
        }
        .bar-val {
            position: absolute;
            top: -15px;
            width: 300%;
            left: -100%;
            font-weight: bold;
            font-size: 6.5pt;
        }
        .bar-lab {
            font-size: 4.5pt;
            margin-top: 4px;
            text-transform: uppercase;
            font-weight: bold;
            color: #6d28d9;
            width: 400%;
            margin-left: -150%;
        }

        .legend-row { margin-top: 15px; font-size: 5.5pt; text-align: center; }
        .legend-item { display: inline-block; margin: 0 5px; }
        .dot { display: inline-block; width: 6px; height: 6px; border-radius: 50%; margin-right: 3px; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="institution-name">Unidad Educativa "Alessandro Volta"</h1>
        <h2 class="report-title">Tabulación de las Pruebas de Diagnóstico</h2>
    </div>

    <table class="meta-table">
        <tr>
            <td class="meta-label">Docente:</td>
            <td>{{ $teacher->name }}</td>
            <td class="meta-label">Curso:</td>
            <td>{{ $course->name }} {{ $course->level }}</td>
        </tr>
        <tr>
            <td class="meta-label">Año Lectivo:</td>
            <td>2025 - 2026</td>
            <td class="meta-label">Materia:</td>
            <td>{{ $subject->name }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th rowspan="2" style="width:20px">Nº</th>
                <th rowspan="2">Nómina</th>
                <th colspan="10">Items (DCD)</th>
                <th rowspan="2" style="width:35px">TOTAL</th>
                <th rowspan="2" style="width:35px">%</th>
                <th rowspan="2" style="width:60px">ESCALA</th>
            </tr>
            <tr>
                @for($i = 1; $i <= 10; $i++)
                    <th style="width:20px">{{ $i }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @foreach($studentsData as $index => $student)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="student-name">{{ $student->name }}</td>
                    @for($i = 1; $i <= 10; $i++)
                        <td>{{ isset($student->selections[$i]) && $student->selections[$i] ? '1' : '' }}</td>
                    @endfor
                    <td style="background:#f5f3ff">{{ $student->total }}</td>
                    <td style="background:#f5f3ff">{{ $student->percentage }}%</td>
                    <td style="background:#f5f3ff; font-size:4.5pt">{{ $student->status['text'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="charts-container">
        <!-- Gráfico de Pastel (Versión IMG Data URI) -->
        <div class="chart-wrapper" style="margin-right: 2%">
            <div class="chart-title">Porcentajes de Rendimiento</div>
            <div class="pie-box">
                @php
                    $svgContent = '<svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">';
                    foreach ($pieData as $slice) {
                        $svgContent .= '<path d="' . $slice['path'] . '" fill="' . $slice['color'] . '" stroke-width="0" />';
                    }
                    $svgContent .= '<circle cx="50" cy="50" r="25" fill="#ffffff" />'; // Donut hole
                    $svgContent .= '</svg>';
                    $base64Svg = base64_encode($svgContent);
                @endphp
                <img src="data:image/svg+xml;base64,{{ $base64Svg }}" class="pie-image">
                {{-- <div class="pie-overlay">{{ $overallPercentage }}%</div> --}}
            </div>
            <div class="legend-row">
                <div class="legend-item"><span class="dot" style="background:#6d28d9"></span>Logrado</div>
                <div class="legend-item"><span class="dot" style="background:#8b5cf6"></span>Proceso</div>
                <div class="legend-item"><span class="dot" style="background:#c4b5fd"></span>Iniciado</div>
            </div>
        </div>

        <!-- Gráfico de Barras -->
        <div class="chart-wrapper">
            <div class="chart-title">Distribución por Escala</div>
            <div class="bar-area">
                @php $maxChart = max(1, max(array_values($statusCounts))); @endphp
                @foreach(['LOGRADO', 'EN PROCESO', 'INICIADO'] as $label)
                    <div class="bar-col">
                        <div class="bar-val">{{ $statusCounts[$label] }}</div>
                        <div class="bar-fill" style="height: {{ ($statusCounts[$label] / $maxChart) * 100 }}%; 
                             background: {{ $label === 'LOGRADO' ? '#6d28d9' : ($label === 'EN PROCESO' ? '#8b5cf6' : '#c4b5fd') }}">
                        </div>
                        <div class="bar-lab">{{ $label === 'EN PROCESO' ? 'PROCESO' : $label }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div style="margin-top: 15px; text-align: center; font-size: 7pt">
        <strong style="color: #6d28d9">DISTRIBUCIÓN DE LOGROS:</strong> &nbsp;&nbsp;
        LOGRADO: {{ $statusCounts['LOGRADO'] }} &nbsp;|&nbsp; 
        PROCESO: {{ $statusCounts['EN PROCESO'] }} &nbsp;|&nbsp; 
        INICIADO: {{ $statusCounts['INICIADO'] }}
    </div>

    <div style="margin-top: 15px">
        <strong style="text-transform: uppercase">Análisis de Resultados:</strong>
        <div style="border-bottom: 0.5px solid #ddd6fe; height: 16px; margin-top: 3px"></div>
        <div style="border-bottom: 0.5px solid #ddd6fe; height: 16px; margin-top: 3px"></div>
    </div>
</body>
</html>

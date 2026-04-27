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
        <tfoot>
            <tr style="font-weight: bold; background: #ffffff;">
                <td colspan="2" style="text-align: right; padding-right: 10px;">TOTAL :</td>
                @for($i = 1; $i <= 10; $i++)
                    <td>{{ $columnTotals[$i] ?? 0 }}</td>
                @endfor
                <td>{{ $totalSelections }}</td>
                <td>{{ $overallPercentage }}%</td>
                <td></td>
            </tr>
            <tr style="font-weight: bold; background: #ffffff;">
                <td colspan="2" style="text-align: right; padding-right: 10px; font-size: 5.5pt">PORCENTAJE :</td>
                @for($i = 1; $i <= 10; $i++)
                    <td>{{ number_format($columnPercentages[$i] ?? 0, 2, ',', '') }}%</td>
                @endfor
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
            </tr>
            <tr style="background: #ffffff; text-align: center;">
                <td colspan="2" style="border: none;"></td>
                @for($i = 1; $i <= 10; $i++)
                    <td style="font-size: 5pt; padding-top: 5px; padding-bottom: 5px; vertical-align: top;">
                        {!! implode('<br>', str_split(str_replace('EN PROCESO', 'PROCESO', $columnEscalas[$i] ?? ''))) !!}
                    </td>
                @endfor
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
            </tr>
        </tfoot>
    </table>

    <table style="width: 100%; margin-top: 15px; border: none;">
        <tr>
            <!-- OBSERVACION -->
            <td style="width: 25%; border: none; vertical-align: top;">
                <div style="font-weight: bold; font-size: 7.5pt; margin-bottom: 5px;">OBSERVACION:</div>
                <div style="font-size: 7pt; line-height: 1.3;">
                    INICIADO = 0% a 38%<br>
                    PROCESO = 39% a 69%<br>
                    LOGRADO = 70% a 100%
                </div>
            </td>

            <!-- Gráfico de Pastel -->
            <td style="width: 35%; border: none; text-align: center; vertical-align: top;">
                <div style="width: 90%; border: 1px solid #ccc; border-radius: 8px; padding: 5px; display: inline-block;">
                    <div style="font-size: 6.5pt; color: #555; margin-bottom: 5px;">Porcentajes</div>
                    <table style="width: 100%; border: none;">
                        <tr>
                            <td style="border: none; text-align: right; width: 55%; vertical-align: middle;">
                                <div style="position: relative; width: 90px; height: 90px; margin: 0 auto;">
                                    @php
                                        $svgContent = '<svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">';
                                        foreach ($pieData as $slice) {
                                            $svgContent .= '<path d="' . $slice['path'] . '" fill="' . $slice['color'] . '" stroke-width="0" />';
                                        }
                                        $svgContent .= '</svg>';
                                        $base64Svg = base64_encode($svgContent);
                                    @endphp
                                    <img src="data:image/svg+xml;base64,{{ $base64Svg }}" style="width: 100%; height: 100%; object-fit: contain;">
                                </div>
                            </td>
                            <td style="border: none; text-align: left; vertical-align: middle; padding-left: 10px; font-size: 5.5pt; font-weight: bold;">
                                <div style="margin-bottom: 4px;"><span style="display: inline-block; width: 6px; height: 6px; background:#4f81bd; margin-right: 3px;"></span>INICIADO</div>
                                <div style="margin-bottom: 4px;"><span style="display: inline-block; width: 6px; height: 6px; background:#c0504d; margin-right: 3px;"></span>PROCESO</div>
                                <div><span style="display: inline-block; width: 6px; height: 6px; background:#9bbb59; margin-right: 3px;"></span>LOGRADO</div>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>

            <!-- Gráfico de Barras -->
            <td style="width: 35%; border: none; text-align: center; vertical-align: top;">
                <div style="width: 90%; border: 1px solid #ccc; border-radius: 8px; padding: 5px; display: inline-block;">
                    <div style="font-size: 6.5pt; color: #555; margin-bottom: 5px;">Porcentajes</div>
                    <table style="width: 100%; border: none;">
                        <tr>
                            <td style="border: none; width: 55%; vertical-align: bottom; height: 90px;">
                                <table style="height: 75px; width: 80%; border-bottom: 1px solid #000; border-left: 1px solid #000; margin: 0 auto; padding: 0;">
                                    <tr>
                                        @php $maxChart = max(1, max(array_values($statusCounts))); @endphp
                                        @foreach(['INICIADO', 'EN PROCESO', 'LOGRADO'] as $label)
                                            <td style="vertical-align: bottom; border: none; padding: 0 4px; width: 33%;">
                                                <div style="width: 18px; height: {{ ($statusCounts[$label] / $maxChart) * 75 }}px; background: {{ $label === 'LOGRADO' ? '#9bbb59' : ($label === 'EN PROCESO' ? '#c0504d' : '#4f81bd') }}; margin: 0 auto;"></div>
                                            </td>
                                        @endforeach
                                    </tr>
                                </table>
                                <div style="text-align: center; font-size: 5pt; margin-top: 2px;">1</div>
                            </td>
                            <td style="border: none; text-align: left; vertical-align: middle; padding-left: 10px; font-size: 5.5pt; font-weight: bold;">
                                <div style="margin-bottom: 4px;"><span style="display: inline-block; width: 6px; height: 6px; background:#4f81bd; margin-right: 3px;"></span>INICIADO</div>
                                <div style="margin-bottom: 4px;"><span style="display: inline-block; width: 6px; height: 6px; background:#c0504d; margin-right: 3px;"></span>PROCESO</div>
                                <div><span style="display: inline-block; width: 6px; height: 6px; background:#9bbb59; margin-right: 3px;"></span>LOGRADO</div>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <div style="margin-top: 20px; border: 1px solid #000; padding: 8px;">
        <strong style="font-size: 8pt; display: block; margin-bottom: 5px;">ANALISIS</strong>
        <div style="font-size: 7pt; text-align: justify; line-height: 1.3;">
            {{ $analisisTexto }}
        </div>
    </div>

    <table style="width: 100%; margin-top: 40px; border: none;">
        <tr>
            <td style="width: 35%; border: none; border-top: 1px solid #000; text-align: center; font-weight: bold; padding-top: 5px; font-size: 7.5pt;">
                {{ mb_strtoupper($teacher->name) }}<br>
                FIRMA DEL DOCENTE
            </td>
            <td style="width: 65%; border: none;"></td>
        </tr>
    </table>
</body>
</html>

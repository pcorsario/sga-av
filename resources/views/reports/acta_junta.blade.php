<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acta Junta de Curso - {{ $course->name }}</title>
    <style>
        @page {
            margin: 20px 30px;
            font-family: Arial, sans-serif;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #000;
            line-height: 1.3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
            vertical-align: middle;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }
        .header-title { font-size: 14px; font-weight: bold; text-align: center; }
        .section-title { background-color: #f0f0f0; font-weight: bold; padding: 5px; border: 1px solid #000; margin-top: 10px; }
        .rotate-text {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            white-space: nowrap;
            height: 120px;
            padding-top: 10px;
            text-align: right;
        }
        .small-text { font-size: 9px; }
    </style>
</head>
<body>
    <table style="border: none; margin-bottom: 0;">
        <tr>
            <td style="border: none; width: 15%; text-align: center;">
                @if(file_exists(public_path('images/logo.png')))
                    <img src="{{ public_path('images/logo.png') }}" style="max-height: 50px;">
                @endif
            </td>
            <td style="border: none; width: 70%; text-align: center;">
                <div class="header-title">UNIDAD EDUCATIVA "ALESSANDRO VOLTA"</div>
                <div class="small-text">
                    Dirección: Coop. Santa Martha Sect. 3. Av. Jacinto Cortez Jhayya y Los Quinches<br>
                    Teléfonos: 3704-269 / 3704-554 / 3704-123  E-mail: col_volta@yahoo.com<br>
                    Santo Domingo - Ecuador
                </div>
            </td>
            <td style="border: none; width: 15%; text-align: center; font-weight: bold;">
                AÑO LECTIVO<br>2025 - 2026
            </td>
        </tr>
    </table>

    <div class="section-title text-center">ACTA JUNTA DE CURSO</div>

    <table>
        <tr>
            <td colspan="4" class="font-bold bg-gray-100">1. Datos Informativos:</td>
        </tr>
        <tr>
            <td colspan="2">DOCENTE TUTOR: <span class="uppercase">{{ $course->tutor->name ?? '' }} {{ $course->tutor->last_name ?? '' }}</span></td>
            <td colspan="2">FIGURA PROFESIONAL: <span class="uppercase">{{ $course->level }}</span></td>
        </tr>
        <tr>
            <td>CURSO: <span class="uppercase">{{ $course->name }}</span></td>
            <td>PARALELO: <span class="uppercase">A</span></td>
            <td>SECCIÓN: <span class="uppercase">MATUTINA</span></td>
            <td>TRIMESTRE: <span class="uppercase">{{ str_replace('t', '', $trimestre) }}ERO</span></td>
        </tr>
    </table>

    <div class="section-title">2. Constatación del quórum (Asistentes):</div>
    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 5%">Nº</th>
                <th class="text-center" style="width: 30%">ASIGNATURA</th>
                <th class="text-center" style="width: 30%">Docente</th>
                <th class="text-center" style="width: 35%">Firma</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subjects as $index => $cs)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="uppercase">{{ $cs->subject->name }}</td>
                <td class="uppercase">{{ $cs->teacher->name ?? '' }} {{ $cs->teacher->last_name ?? '' }}</td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">3. Informe del Rendimiento Académico por Asignaturas. Estudiantes con calificaciones menores a 7,00 o que no tienen calificaciones.</div>
    <table>
        <thead>
            <tr>
                <th rowspan="2" class="text-center" style="width: 3%">Nº</th>
                <th rowspan="2" class="text-center" style="width: 25%">NÓMINA ESTUDIANTES</th>
                <th colspan="{{ $subjects->count() }}" class="text-center">CALIFICACIONES MENORES A 7,00</th>
            </tr>
            <tr>
                @foreach($subjects as $cs)
                <th class="rotate-text text-center"><span style="display:inline-block; transform: rotate(-90deg); width: 15px;">{{ $cs->subject->name }}</span></th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($studentsBelowSeven as $index => $data)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="uppercase">{{ $data['student']->last_name }} {{ $data['student']->name }}</td>
                @foreach($subjects as $cs)
                    @php
                        $avgData = $data['averages'][$cs->id];
                    @endphp
                    <td class="text-center">
                        @if($avgData['sin_calificacion'])
                            SC
                        @elseif($avgData['promedio'] !== null && $avgData['promedio'] < 7)
                            {{ number_format($avgData['promedio'], 2) }}
                        @endif
                    </td>
                @endforeach
            </tr>
            @endforeach
            @if(count($studentsBelowSeven) === 0)
            <tr>
                <td colspan="{{ $subjects->count() + 2 }}" class="text-center">Ningún estudiante registró calificaciones menores a 7,00.</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="font-bold text-center">PROMEDIO TRIMESTRAL DEL CURSO</td>
                @foreach($subjects as $cs)
                    <td class="text-center font-bold">{{ number_format($subjectAverages[$cs->id] ?? 0, 2) }}</td>
                @endforeach
            </tr>
        </tfoot>
    </table>

    <div class="section-title">4. Análisis de estudiantes con Necesidades Educativas Específicas (NEE).</div>
    <table style="border: 1px solid #000; padding: 10px;">
        <tr>
            <td style="border: none;">
                {!! nl2br(e($setting->nee_students ?? 'En el curso no existen estudiantes con NEE o no se ha registrado análisis.')) !!}
            </td>
        </tr>
    </table>

    <div class="section-title">5. Lectura del informe del Departamento de Consejería Estudiantil (DECE).</div>
    <table style="border: 1px solid #000; padding: 10px;">
        <tr>
            <td style="border: none;">
                @if($deceOptions->count() > 0)
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($deceOptions as $opt)
                            <li>{{ $opt->description }}</li>
                        @endforeach
                    </ul>
                @else
                    No se registraron reportes.
                @endif
            </td>
        </tr>
    </table>

    <div class="section-title">6. Análisis del Comportamiento Estudiantil.</div>
    <table style="border: 1px solid #000; padding: 10px;">
        <tr>
            <td style="border: none;">
                @if($behaviorOptions->count() > 0)
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($behaviorOptions as $opt)
                            <li>{{ $opt->description }}</li>
                        @endforeach
                    </ul>
                @else
                    No se registraron observaciones de comportamiento.
                @endif
            </td>
        </tr>
    </table>

    <div class="section-title">7. Resoluciones.</div>
    <table style="border: 1px solid #000; padding: 10px;">
        <tr>
            <td style="border: none;">
                @if($resolutionOptions->count() > 0)
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($resolutionOptions as $opt)
                            <li>{{ $opt->description }}</li>
                        @endforeach
                    </ul>
                @else
                    No se registraron resoluciones.
                @endif
            </td>
        </tr>
    </table>

    <br><br>

    <table style="border: none; margin-top: 40px;">
        <tr>
            <td style="border: none; width: 50%; text-align: center;">
                _________________________________________<br>
                <span class="font-bold uppercase">TUTOR: {{ $course->tutor->name ?? '' }} {{ $course->tutor->last_name ?? '' }}</span>
            </td>
            <td style="border: none; width: 50%; text-align: center;">
                _________________________________________<br>
                <span class="font-bold uppercase">VICERRECTORADO</span>
            </td>
        </tr>
    </table>
</body>
</html>

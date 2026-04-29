<?php

namespace App\Http\Controllers;

use App\Models\CourseSubject;
use App\Models\ReportOption;
use App\Models\ReportSetting;
use Illuminate\Http\Request;

class ReportSettingController extends Controller
{
    public function show(CourseSubject $courseSubject, string $trimestre)
    {
        $options = ReportOption::all()->groupBy(['type', 'category']);

        $setting = ReportSetting::firstOrCreate(
            [
                'course_subject_id' => $courseSubject->id,
                'trimestre' => $trimestre,
            ],
            [
                'destrezas_planificadas' => 0,
                'destrezas_logradas' => 0,
                'factores' => ReportOption::where('type', 'factor')->where('is_default', true)->pluck('id')->toArray(),
                'causas' => ReportOption::where('type', 'causa')->where('is_default', true)->pluck('id')->toArray(),
                'medidas' => ReportOption::where('type', 'medida')->where('is_default', true)->pluck('id')->toArray(),
                'recomendaciones' => ReportOption::where('type', 'recomendacion')->where('is_default', true)->pluck('id')->toArray(),
            ]
        );

        return response()->json([
            'options' => $options,
            'setting' => $setting,
        ]);
    }

    public function update(Request $request, CourseSubject $courseSubject, string $trimestre)
    {
        $validated = $request->validate([
            'destrezas_planificadas' => 'required|integer|min:0',
            'destrezas_logradas' => 'required|integer|min:0',
            'factores' => 'nullable|array',
            'causas' => 'nullable|array',
            'medidas' => 'nullable|array',
            'recomendaciones' => 'nullable|array',
        ]);

        $setting = ReportSetting::updateOrCreate(
            [
                'course_subject_id' => $courseSubject->id,
                'trimestre' => $trimestre,
            ],
            $validated
        );

        return response()->json(['message' => 'Configuración guardada correctamente.', 'setting' => $setting]);
    }
}

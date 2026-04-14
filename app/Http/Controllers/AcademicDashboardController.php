<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AcademicDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $data = [];

        if ($user->hasRole(RoleEnum::Autoridad->value)) {
            $data['role'] = 'autoridad';
            $data['stats'] = [
                'students_count' => User::role(RoleEnum::Estudiante->value)->count(),
                'teachers_count' => User::role(RoleEnum::Profesor->value)->count(),
                'courses_count' => Course::count(),
                'parents_count' => User::role(RoleEnum::Padre->value)->count(),
            ];
        } elseif ($user->hasRole(RoleEnum::Profesor->value)) {
            $data['role'] = 'profesor';
            $data['assigned_subjects'] = $user->assignedSubjects()->with(['course', 'subject'])->get();
        } elseif ($user->hasRole(RoleEnum::Estudiante->value)) {
            $data['role'] = 'estudiante';
            $data['enrollments'] = $user->enrollments()->with(['course'])->get();
            $data['grades'] = $user->grades()->with(['courseSubject.subject'])->get();
        } elseif ($user->hasRole(RoleEnum::Padre->value)) {
            $data['role'] = 'padre';
            $data['children'] = $user->children()->with(['enrollments.course', 'grades.courseSubject.subject'])->get();
        }

        return Inertia::render('Dashboard', [
            'academic' => $data,
        ]);
    }
}

<?php

use App\Http\Controllers\AcademicDashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\Teams\TeamInvitationController;
use App\Http\Middleware\EnsureTeamMembership;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->hasRole(App\Enums\RoleEnum::Profesor->value)) {
            return redirect()->route('teachers.dashboard');
        }
        return redirect()->route('dashboard', ['current_team' => $user->currentTeam->slug]);
    }

    return redirect()->route('login');
})->name('home');

// Route::inertia('/', 'Welcome', [
//     'canRegister' => Features::enabled(Features::registration()),
// ])->name('home');

// Route::redirect('/', '/login')->name('home');

Route::prefix('teachers')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('dashboard', AcademicDashboardController::class)->name('teachers.dashboard');
        Route::get('grades/{courseSubject}', [GradeController::class, 'edit'])->name('teachers.grades.edit');
        Route::post('grades/{courseSubject}', [GradeController::class, 'update'])->name('teachers.grades.update');
    });

Route::prefix('{current_team}')
    ->middleware(['auth', 'verified', EnsureTeamMembership::class])
    ->group(function () {
        Route::get('dashboard', AcademicDashboardController::class)->name('dashboard');

        // Rutas Académicas
        Route::get('grades/{courseSubject}', [GradeController::class, 'edit'])->name('grades.edit');
        Route::post('grades/{courseSubject}', [GradeController::class, 'update'])->name('grades.update');

        // Malla Curricular (Cursos y Materias)
        Route::post('subjects', [SubjectController::class, 'store'])->name('subjects.store');
        Route::get('courses/{course}/subjects', [CourseController::class, 'subjects'])->name('courses.subjects');
        Route::post('courses/{course}/subjects', [CourseController::class, 'updateSubjects'])->name('courses.subjects.update');
        Route::resource('courses', CourseController::class);

        // Alumnos y Matrículas
        Route::resource('students', StudentController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
            ->parameters(['students' => 'student']);

        // Padres de Familia / Representantes
        Route::resource('parents', ParentController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
            ->parameters(['parents' => 'parent']);

        // Nómina de Profesores
        Route::get('teachers/{teacher}/subjects', [TeacherController::class, 'subjects'])->name('teachers.subjects');
        Route::post('teachers/{teacher}/subjects', [TeacherController::class, 'updateSubjects'])->name('teachers.subjects.update');
        Route::resource('teachers', TeacherController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
            ->parameters(['teachers' => 'teacher']);
    });


Route::middleware(['auth'])->group(function () {
    Route::get('invitations/{invitation}/accept', [TeamInvitationController::class, 'accept'])->name('invitations.accept');
});

require __DIR__ . '/settings.php';

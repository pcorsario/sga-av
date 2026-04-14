<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Course;
use App\Models\CourseSubject;
use App\Models\Enrollment;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;

class AcademicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear Materias
        $subjects = [
            'Matemáticas', 'Lengua y Literatura', 'Ciencias Naturales',
            'Estudios Sociales', 'Inglés', 'Educación Física',
        ];

        foreach ($subjects as $name) {
            Subject::firstOrCreate(['name' => $name]);
        }

        // 2. Crear Cursos
        $courses = [
            ['name' => '8vo EGB', 'level' => 'Básica Superior'],
            ['name' => '9no EGB', 'level' => 'Básica Superior'],
            ['name' => '10mo EGB', 'level' => 'Básica Superior'],
            ['name' => '1ro BGU', 'level' => 'Bachillerato'],
        ];

        foreach ($courses as $courseData) {
            Course::firstOrCreate($courseData);
        }

        // 3. Asignar Materias a Cursos y Profesores
        $teacher = User::role(RoleEnum::Profesor->value)->first();
        $courseIds = Course::pluck('id');
        $subjectIds = Subject::pluck('id');

        foreach ($courseIds as $cId) {
            foreach ($subjectIds as $sId) {
                CourseSubject::firstOrCreate([
                    'course_id' => $cId,
                    'subject_id' => $sId,
                ], [
                    'teacher_id' => $teacher?->id,
                ]);
            }
        }

        // 4. Matricular Estudiantes y asignar Padres
        $student = User::role(RoleEnum::Estudiante->value)->first();
        $parent = User::role(RoleEnum::Padre->value)->first();

        if ($student && $courseIds->isNotEmpty()) {
            foreach ($courseIds as $cId) {
                Enrollment::firstOrCreate([
                    'course_id' => $cId,
                    'student_id' => $student->id,
                ]);
            }
        }

        if ($student && $parent) {
            $parent->children()->syncWithoutDetaching([$student->id]);
        }

        // 5. Crear 25 estudiantes adicionales para 8vo EGB
        $octavoEgb = Course::where('name', '8vo EGB')->first();
        if ($octavoEgb) {
            for ($i = 1; $i <= 25; $i++) {
                $newStudent = User::factory()->create([
                    'name' => "Estudiante {$octavoEgb->name} {$i}",
                    'email' => "estudiante8vo{$i}@example.com",
                    'password' => bcrypt('password'),
                ]);
                $newStudent->assignRole(RoleEnum::Estudiante->value);

                Enrollment::firstOrCreate([
                    'course_id' => $octavoEgb->id,
                    'student_id' => $newStudent->id,
                ]);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole(RoleEnum::Autoridad->value);

        $teacher = User::factory()->create([
            'name' => 'Profesor User',
            'email' => 'profesor@example.com',
            'password' => bcrypt('password'),
        ]);
        $teacher->assignRole(RoleEnum::Profesor->value);

        $parent = User::factory()->create([
            'name' => 'Padre User',
            'email' => 'padre@example.com',
            'password' => bcrypt('password'),
        ]);
        $parent->assignRole(RoleEnum::Padre->value);

        $student = User::factory()->create([
            'name' => 'Estudiante User',
            'email' => 'estudiante@example.com',
            'password' => bcrypt('password'),
        ]);
        $student->assignRole(RoleEnum::Estudiante->value);

        //        $this->call(AcademicSeeder::class);
        //      $this->call(EnrollmentSeeder::class);

    }
}

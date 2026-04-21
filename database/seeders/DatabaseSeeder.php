<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $admin->assignRole(\App\Enums\RoleEnum::Autoridad->value);

        $teacher = User::factory()->create([
            'name' => 'Profesor User',
            'email' => 'profesor@example.com',
            'password' => bcrypt('password'),
        ]);
        $teacher->assignRole(\App\Enums\RoleEnum::Profesor->value);

        $parent = User::factory()->create([
            'name' => 'Padre User',
            'email' => 'padre@example.com',
            'password' => bcrypt('password'),
        ]);
        $parent->assignRole(\App\Enums\RoleEnum::Padre->value);

        $student = User::factory()->create([
            'name' => 'Estudiante User',
            'email' => 'estudiante@example.com',
            'password' => bcrypt('password'),
        ]);
        $student->assignRole(\App\Enums\RoleEnum::Estudiante->value);

//        $this->call(AcademicSeeder::class);
  //      $this->call(EnrollmentSeeder::class);
        
    }
}

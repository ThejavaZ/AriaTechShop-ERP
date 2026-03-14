<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
   public function run(): void
{
    // 1. Primero crear el usuario admin
    $admin = User::factory()->create([
        'name' => 'admin',
        'email' => 'admin@ariatechshop.com',
        'password' => Hash::make('password'),
        'role' => 1,
        'language' => 1,
        'status' => 1,
        'is_active' => 1
    ]);

    // 2. Luego roles y permisos
    $this->call([
    RolesAndPermissionsSeeder::class,  // solo clases aquí
    RepairSeeder::class,
    ]);

    // 3. Asignar rol al admin
    $admin->assignRole('admin');
} 
}

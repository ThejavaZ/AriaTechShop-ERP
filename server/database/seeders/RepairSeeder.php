<?php

namespace Database\Seeders;

use App\Models\Repair;
use App\Models\RepairStatusHistory;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RepairSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'tecnico', 'guard_name' => 'web']);
        // Lista de técnicos para el taller
        $technicians = [
            [
                'name' => 'Carlos Mendoza',
                'email' => 'carlos.mendoza@ariatechshop.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Ana Sofía Garza',
                'email' => 'ana.garza@ariatechshop.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Luis Fernando Torres',
                'email' => 'luis.torres@ariatechshop.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'María José Valenzuela',
                'email' => 'maria.valenzuela@ariatechshop.com',
                'password' => Hash::make('password123'),
            ],
        ]; // <-- Corregido: aquí debe ser corchete y punto y coma
        foreach ($technicians as $techData) {
        $technician = User::firstOrCreate(
        ['email' => $techData['email']],
        [
            'name' => $techData['name'],
            'password' => $techData['password'],
        ]
    );

    if (!$technician->hasRole('tecnico')) {
        $technician->assignRole('tecnico');
    }

        // Crear reparaciones en diferentes estados

        // 5 Pendientes
        Repair::factory(5)->pending()->create()->each(function ($repair) {
            RepairStatusHistory::create([
                'repair_id' => $repair->id,
                'status_to' => 'pending',
                'notes' => 'Reparación registrada en el sistema',
                'changed_by' => null,
            ]);
        });

        // 3 Diagnosticadas
        Repair::factory(3)->create(['status' => 'diagnosed'])->each(function ($repair) {
            RepairStatusHistory::create([
                'repair_id' => $repair->id,
                'status_to' => 'pending',
                'notes' => 'Reparación registrada',
            ]);
            RepairStatusHistory::create([
                'repair_id' => $repair->id,
                'status_from' => 'pending',
                'status_to' => 'diagnosed',
                'notes' => 'Diagnóstico completado',
                'changed_by' => User::inRandomOrder()->first()->id,
            ]);
        });

        // 4 En progreso
        Repair::factory(4)->inProgress()->create()->each(function ($repair) {
            RepairStatusHistory::create([
                'repair_id' => $repair->id,
                'status_to' => 'pending',
                'notes' => 'Reparación registrada',
            ]);
            RepairStatusHistory::create([
                'repair_id' => $repair->id,
                'status_from' => 'pending',
                'status_to' => 'in_progress',
                'notes' => 'Iniciando reparación',
                'changed_by' => $repair->assigned_to,
            ]);
        });

        // 5 Completadas
        Repair::factory(5)->completed()->create()->each(function ($repair) {
            RepairStatusHistory::create([
                'repair_id' => $repair->id,
                'status_to' => 'pending',
                'notes' => 'Reparación registrada',
            ]);
            RepairStatusHistory::create([
                'repair_id' => $repair->id,
                'status_from' => 'pending',
                'status_to' => 'in_progress',
                'notes' => 'Iniciando reparación',
                'changed_by' => $repair->assigned_to,
            ]);
            RepairStatusHistory::create([
                'repair_id' => $repair->id,
                'status_from' => 'in_progress',
                'status_to' => 'completed',
                'notes' => 'Reparación finalizada exitosamente',
                'changed_by' => $repair->assigned_to,
            ]);
        });

        // 3 Entregadas
        Repair::factory(3)->delivered()->create()->each(function ($repair) {
            RepairStatusHistory::create([
                'repair_id' => $repair->id,
                'status_to' => 'pending',
                'notes' => 'Reparación registrada',
            ]);
            RepairStatusHistory::create([
                'repair_id' => $repair->id,
                'status_from' => 'pending',
                'status_to' => 'completed',
                'notes' => 'Reparación completada',
                'changed_by' => $repair->assigned_to,
            ]);
            RepairStatusHistory::create([
                'repair_id' => $repair->id,
                'status_from' => 'completed',
                'status_to' => 'delivered',
                'notes' => 'Equipo entregado al cliente',
                'changed_by' => $repair->assigned_to,
            ]);
        });

        $this->command->info('✅ Se crearon '.Repair::count().' reparaciones con su historial');
    }
}
}
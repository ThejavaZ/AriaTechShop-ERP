<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'user.view', 'user.create', 'user.edit', 'user.delete',
            'sales.view', 'sales.create', 'sales.delete',
            'repairs.view', 'repairs.create', 'repairs.update', 'repairs.delete',
            'repairs.change_status', 'repairs.send_survey',
            'notifications.send',
            'inventory.view', 'inventory.create', 'inventory.update', 'inventory.restock',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Rol: Técnico (solo reparaciones)
        $tecnico = Role::firstOrCreate(['name' => 'tecnico']);
        $tecnico->syncPermissions([
            'repairs.view',
            'repairs.update',
            'repairs.change_status',
        ]);

        // Rol: Vendedor (solo ventas e inventario)
        $vendedor = Role::firstOrCreate(['name' => 'vendedor']);
        $vendedor->syncPermissions([
            'sales.view',
            'sales.create',
            'inventory.view',
        ]);

        // Rol: Admin (todos los permisos)
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());
    }
}
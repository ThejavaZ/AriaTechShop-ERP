<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class RbacTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }

    // Prueba 1: usuario sin rol recibe 401 al no estar autenticado
    public function test_usuario_no_autenticado_no_puede_acceder_a_ventas()
    {
        $response = $this->getJson('/api/sales');
        $response->assertStatus(401);
    }

    // Prueba 2: usuario con rol tecnico no puede eliminar ventas
    public function test_tecnico_no_puede_eliminar_ventas()
    {
        Permission::create(['name' => 'sales.delete']);
        $tecnico = Role::create(['name' => 'tecnico']);

        $user = User::factory()->create();
        $user->assignRole('tecnico');

        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->deleteJson('/api/sales/1');

        $response->assertStatus(403);
    }
}
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_exitoso()
    {
        $role = Role::create(['name' => 'admin']);

        $user = User::factory()->create([
            'email'    => 'admin@ariatechshop.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('admin');

        $response = $this->postJson('/api/auth/login', [
            'email'    => 'admin@ariatechshop.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['token', 'user', 'roles']);
    }

    public function test_login_credenciales_incorrectas()
    {
        User::factory()->create([
            'email'    => 'admin@ariatechshop.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email'    => 'admin@ariatechshop.com',
            'password' => 'incorrecta',
        ]);

        $response->assertStatus(401);
    }

    public function test_ruta_protegida_sin_token()
    {
        $response = $this->getJson('/api/auth/me');
        $response->assertStatus(401);
    }

    public function test_ruta_protegida_con_token()
    {
        $role = Role::create(['name' => 'admin']);
        $user = User::factory()->create();
        $user->assignRole('admin');

        $token = $user->createToken('test')->plainTextToken;

        $response = $this->getJson('/api/auth/me', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['user', 'roles', 'permissions']);
    }

    public function test_acceso_denegado_sin_permiso()
    {
        Role::create(['name' => 'tecnico']);
        $user = User::factory()->create();
        $user->assignRole('tecnico');

        $token = $user->createToken('test')->plainTextToken;

        $response = $this->deleteJson('/api/sales/1', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(403);
    }
}
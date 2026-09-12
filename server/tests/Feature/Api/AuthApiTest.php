<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('register de usuario retorna 201 con el usuario', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'Cliente Prueba',
        'email' => 'cliente@ariatech.test',
        'password' => 'Str0ng!Pass',
        'password_confirmation' => 'Str0ng!Pass',
    ]);

    $response
        ->assertStatus(201)
        ->assertJsonFragment(['message' => 'Usuario registrado con éxito'])
        ->assertJsonPath('user.email', 'cliente@ariatech.test');

    $this->assertDatabaseHas('users', ['email' => 'cliente@ariatech.test']);
});

test('register rechaza password debil', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'Cliente Prueba',
        'email' => 'cliente2@ariatech.test',
        'password' => '123',
        'password_confirmation' => '123',
    ]);

    $response->assertStatus(422);
});

test('login retorna 200 con credenciales válidas', function () {
    $user = User::factory()->create([
        'password' => Hash::make('Str0ng!Pass'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'Str0ng!Pass',
    ]);

    $response
        ->assertStatus(200)
        ->assertJsonFragment(['message' => 'Login exitoso']);
});

test('login rechaza credenciales incorrectas', function () {
    $user = User::factory()->create([
        'password' => Hash::make('Str0ng!Pass'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $response->assertStatus(401)->assertJson(['message' => 'Credenciales incorrectas']);
});

test('un usuario genera token de acceso Sanctum en texto plano', function () {
    $user = User::factory()->create();

    $token = $user->createToken('auth_token')->plainTextToken;

    expect($token)->toBeString()->not->toBeEmpty();

    $this->assertDatabaseCount('personal_access_tokens', 1);
});
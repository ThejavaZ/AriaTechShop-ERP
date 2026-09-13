<?php

use App\Models\Repair;
use App\Models\User;
use App\Services\EmailApiService;

test('se puede registrar una reparación válida', function () {
    $this->mock(EmailApiService::class)
        ->shouldReceive('sendEmail')
        ->andReturn(['success' => true, 'message' => 'ok']);

    $response = $this->postJson('/api/repairs', [
        'customer_name' => 'Ramón Viera',
        'customer_email' => 'ramon@ariatech.test',
        'customer_phone' => '6621234567',
        'device_type' => 'Laptop',
        'brand' => 'Dell',
        'model' => 'Inspiron 15',
        'serial_number' => 'SN-00000001',
        'issue_description' => 'No enciende',
        'estimated_cost' => 500.00,
    ]);

    $response
        ->assertStatus(201)
        ->assertJson(['success' => true])
        ->assertJsonPath('data.status', 'pending');

    $this->assertDatabaseHas('repairs', [
        'customer_email' => 'ramon@ariatech.test',
        'status' => 'pending',
    ]);
});

test('registro de reparación valida los datos obligatorios', function () {
    $this->mock(EmailApiService::class)
        ->shouldReceive('sendEmail')
        ->andReturn(['success' => true, 'message' => 'ok']);

    $response = $this->postJson('/api/repairs', [
        'customer_email' => 'correo-invalido',
        'device_type' => '',
    ]);

    $response->assertStatus(422);
});

test('el número de reparación se genera de forma secuencial', function () {
    Repair::factory()->create(['repair_number' => 'RRP-00042']);

    expect(Repair::generateRepairNumber())->toBe('RRP-00043');
});

test('se puede listar reparaciones', function () {
    Repair::factory()->count(3)->create();

    $response = $this->getJson('/api/repairs');

    $response
        ->assertOk()
        ->assertJsonCount(3, 'data');
});

test('las reparaciones se pueden filtrar por estado', function () {
    Repair::factory()->pending()->count(2)->create();
    Repair::factory()->completed()->create();

    $response = $this->getJson('/api/repairs?status=pending');

    $response
        ->assertOk()
        ->assertJsonCount(2, 'data');
});
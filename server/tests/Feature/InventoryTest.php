<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Inventory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InventoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_inventory_can_be_created()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/inventory', [
            'name' => 'iPhone 15',
            'category' => 'Celulares',
            'price' => 15000,
            'stock' => 10,
            'description' => 'Nuevo'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('inventories', [
            'name' => 'iPhone 15'
        ]);
    }

    public function test_inventory_index_is_accessible()
    {
        $user = User::factory()->create();

        Inventory::factory()->count(3)->create();

        $response = $this->actingAs($user)->get('/inventory');

        $response->assertStatus(200);
        $response->assertViewIs('inventory.index');
        $response->assertViewHas('products');
    }
}
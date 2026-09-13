<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;

function makeProduct(array $overrides = []): Product
{
    $category = Category::create([
        'name' => 'Tarjetas de Video',
        'slug' => 'tarjetas-de-video',
        'description' => 'Hardware gráfico',
        'is_active' => true,
    ]);

    return Product::create(array_merge([
        'name' => 'RTX 5090',
        'slug' => 'rtx-5090',
        'description' => 'Tarjeta de video de gama alta',
        'category_id' => $category->id,
        'stock' => 5,
        'min_stock' => 2,
        'price' => 30000.00,
        'cost' => 25000.00,
        'is_active' => true,
    ], $overrides));
}

test('el catálogo público lista productos activos', function () {
    makeProduct();

    $response = $this->getJson('/api/products');

    $response
        ->assertOk()
        ->assertJson(['success' => true])
        ->assertJsonCount(1, 'data');
});

test('el catálogo excluye productos inactivos', function () {
    makeProduct(['is_active' => false]);

    $response = $this->getJson('/api/products');

    $response->assertOk()->assertJsonCount(0, 'data');
});

test('el catálogo filtra productos por categoría', function () {
    makeProduct();

    $response = $this->getJson('/api/products?category_id=999');

    $response->assertOk()->assertJsonCount(0, 'data');
});

test('se muestra un producto por su slug', function () {
    makeProduct();

    $response = $this->getJson('/api/products/rtx-5090');

    $response
        ->assertOk()
        ->assertJsonPath('data.name', 'RTX 5090')
        ->assertJsonPath('data.stock', 5);
});

test('un slug inexistente devuelve 404', function () {
    $response = $this->getJson('/api/products/no-existe');

    $response->assertNotFound();
});

test('el catálogo público devuelve categorías activas', function () {
    Category::create(['name' => 'Procesadores', 'slug' => 'procesadores', 'is_active' => true]);
    Category::create(['name' => 'Oculta', 'slug' => 'oculta', 'is_active' => false]);

    $response = $this->getJson('/api/categories');

    $response
        ->assertOk()
        ->assertJson(['success' => true])
        ->assertJsonCount(1, 'data');
});
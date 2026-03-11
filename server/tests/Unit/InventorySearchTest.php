<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Inventory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class InventorySearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Inventory::factory()->create(['name' => 'Cable HDMI',     'category' => 'Electrónica', 'price' => 45,  'stock' => 80, 'min_stock' => 5]);
        Inventory::factory()->create(['name' => 'Clavos 2"',      'category' => 'Ferretería',  'price' => 1.5, 'stock' => 3,  'min_stock' => 10]);
        Inventory::factory()->create(['name' => 'Pintura Blanca', 'category' => 'Acabados',    'price' => 120, 'stock' => 25, 'min_stock' => 5]);
        Inventory::factory()->create(['name' => 'Tornillo 5mm',   'category' => 'Ferretería',  'price' => 0.5, 'stock' => 5,  'min_stock' => 10]);
        Inventory::factory()->create(['name' => 'Cable Eléctrico','category' => 'Eléctrico',   'price' => 85,  'stock' => 40, 'min_stock' => 5]);
    }

    #[Test]
    public function buscar_retorna_todos_los_productos_sin_filtros(): void
    {
        $results = Inventory::buscar();

        $this->assertEquals(5, $results->total());
    }

    #[Test]
    public function buscar_filtra_por_nombre_con_like(): void
    {
        $results = Inventory::buscar(search: 'Cable');

        $this->assertEquals(2, $results->total());
        $nombres = $results->pluck('name')->toArray();
        $this->assertContains('Cable HDMI', $nombres);
        $this->assertContains('Cable Eléctrico', $nombres);
    }

    #[Test]
    public function buscar_retorna_vacio_cuando_no_hay_coincidencias(): void
    {
        $results = Inventory::buscar(search: 'ProductoQueNoExiste');

        $this->assertEquals(0, $results->total());
    }

    #[Test]
    public function buscar_es_case_insensitive(): void
    {
        $results = Inventory::buscar(search: 'cable');

        $this->assertEquals(2, $results->total());
    }

    #[Test]
    public function buscar_filtra_por_categoria(): void
    {
        $results = Inventory::buscar(category: 'Ferretería');

        $this->assertEquals(2, $results->total());
        foreach ($results as $product) {
            $this->assertEquals('Ferretería', $product->category);
        }
    }

    #[Test]
    public function buscar_combina_nombre_y_categoria(): void
    {
        $results = Inventory::buscar(search: 'Clav', category: 'Ferretería');

        $this->assertEquals(1, $results->total());
        $this->assertEquals('Clavos 2"', $results->first()->name);
    }

    #[Test]
    public function buscar_ordena_por_precio_ascendente(): void
    {
        $results = Inventory::buscar(sort: 'price', order: 'asc');

        $precios = $results->pluck('price')->toArray();
        $sorted  = $precios;
        sort($sorted);
        $this->assertEquals($sorted, $precios);
    }

    #[Test]
    public function buscar_ordena_por_stock_descendente(): void
    {
        $results = Inventory::buscar(sort: 'stock', order: 'desc');

        $stocks = $results->pluck('stock')->toArray();
        $sorted = $stocks;
        rsort($sorted);
        $this->assertEquals($sorted, $stocks);
    }

    #[Test]
    public function buscar_ignora_columna_de_orden_invalida(): void
    {
        $results = Inventory::buscar(sort: 'columna_inventada');

        $this->assertEquals(5, $results->total());
    }

    #[Test]
    public function obtenerCategorias_retorna_lista_unica_de_categorias(): void
    {
        $categories = Inventory::obtenerCategorias();

        $this->assertCount(4, $categories);
        $this->assertContains('Ferretería',  $categories);
        $this->assertContains('Electrónica', $categories);
        $this->assertContains('Acabados',    $categories);
        $this->assertContains('Eléctrico',   $categories);
    }

    #[Test]
    public function obtenerCategorias_no_repite_categorias_duplicadas(): void
    {
        $categories = Inventory::obtenerCategorias();

        $this->assertEquals(
            count($categories),
            count(array_unique($categories))
        );
    }
}
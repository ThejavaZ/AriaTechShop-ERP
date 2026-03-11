<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function create()
    {
        return view('inventory.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'description' => 'nullable|string'
        ]);

        Inventory::create($validated);

        return redirect()->back()
            ->with('success', 'Producto registrado correctamente');
    }

    public function index(Request $request)
    {
        $search   = $request->input('search');
        $category = $request->input('category');
        $sort     = $request->input('sort', 'name');
        $order    = $request->input('order', 'asc');

        $products   = Inventory::buscar($search, $category, $sort, $order);
        $categories = Inventory::obtenerCategorias();

        return view('inventory.index', compact('products', 'categories', 'search', 'category', 'sort', 'order'));
    }

    public function edit(int $id)
    {
        $product = Inventory::findOrFail($id);

        return view('inventory.edit', compact('product'));
    }

    public function restock()
    {
        $products = Inventory::all();

        return view('inventory.restock', compact('products'));
    }

    public function storeRestock(Request $request)
    {
        $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'cantidad' => 'required|integer|min:1'
        ]);

        Inventory::registrarRestock(
            $request->inventory_id,
            $request->cantidad
        );

        return redirect()->route('inventory.index')
            ->with('success', 'Restock registrado correctamente');
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'description' => 'nullable|string'
        ]);

        Inventory::actualizarProducto($id, $validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Producto actualizado correctamente');
    }
}
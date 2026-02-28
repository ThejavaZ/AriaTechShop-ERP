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
            'description' => 'nullable|string'
        ]);

        Inventory::create($validated);

        return redirect()->back()->with('success', 'Producto registrado correctamente');
    }

    public function index()
    {
        $products = Inventory::listar();
        return view('inventory.index', compact('products'));
    }

        public function edit(int $id)
    {
        $product = Inventory::findOrFail($id);
        return view('inventory.edit', compact('product'));
    }

    public function updatePrice(Request $request, int $id)
    {
        $request->validate([
            'price' => 'required|numeric|min:0'
        ]);

        Inventory::actualizarPrecio($id, $request->price);

        return redirect()->route('inventory.index')
                        ->with('success', 'Precio actualizado correctamente');
    }
}
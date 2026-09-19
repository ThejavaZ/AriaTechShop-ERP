<?php

namespace App\Observers;

use App\Models\AuditLog;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;

class InventoryObserver
{
    public function created(Inventory $inventory)
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'creado',
            'product_id' => $inventory->id,
            'description' => "Producto {$inventory->name} registrado",
        ]);
    }

    public function updated(Inventory $inventory): void
    {
        if ($inventory->wasChanged('price')) {
            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => 'precio_actualizado',
                'product_id' => $inventory->id,
                'description' => "Precio de {$inventory->name} cambió de {$inventory->getOriginal('price')} a {$inventory->price}",
            ]);
        }

        if ($inventory->wasChanged('stock')) {
            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => 'stock_actualizado',
                'product_id' => $inventory->id,
                'description' => "Stock de {$inventory->name} cambió de {$inventory->getOriginal('stock')} a {$inventory->stock}",
            ]);
        }
    }

    public function deleted(Inventory $inventory): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'eliminado',
            'product_id' => $inventory->id,
            'description' => "Producto {$inventory->name} eliminado",
        ]);
    }

    public function restored(Inventory $inventory): void {}
    public function forceDeleted(Inventory $inventory): void {}
}
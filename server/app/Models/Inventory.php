<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'price',
        'stock',
        'min_stock',
        'description'
    ];

    protected static function booted()
    {
        static::created(function ($inventory) {
            Log::info('Producto registrado en inventario: ' . $inventory->name);
        });

        static::updated(function ($inventory) {

            if ($inventory->wasChanged('price')) {
                Log::info('Precio actualizado', [
                    'producto_id' => $inventory->id,
                    'nombre' => $inventory->name,
                    'precio_anterior' => $inventory->getOriginal('price'),
                    'precio_nuevo' => $inventory->price,
                ]);
            }

            if ($inventory->wasChanged('stock')) {
                Log::info('Stock actualizado', [
                    'producto_id' => $inventory->id,
                    'nombre' => $inventory->name,
                    'stock_anterior' => $inventory->getOriginal('stock'),
                    'stock_nuevo' => $inventory->stock,
                ]);
            }
        });
    }

    public static function listar()
    {
        return self::select(
            'id',
            'name',
            'category',
            'price',
            'stock',
            'min_stock'
        )
            ->orderBy('name')
            ->paginate(10);
    }

    public static function actualizarProducto(int $id, array $datos): self
    {
        $producto = self::findOrFail($id);
        $producto->update($datos);

        return $producto;
    }

    public static function registrarRestock(int $id, int $cantidad): self
    {
        $producto = self::findOrFail($id);

        $producto->stock += $cantidad;
        $producto->save();

        return $producto;
    }

    public function tieneStockBajo(): bool
    {
        return $this->stock <= $this->min_stock;
    }
}

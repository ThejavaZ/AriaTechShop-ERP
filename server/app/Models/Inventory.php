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
        'description'
    ];

    // Registrar automáticamente en logs cuando se crea
    protected static function booted()
    {
        static::created(function ($inventory) {
            Log::info('Producto registrado en inventario: ' . $inventory->name);
        });
    }

    public static function listar()
    {
        return self::select('name', 'category', 'price', 'stock')
                   ->orderBy('name')
                   ->paginate(10);
    }
}
<?php

namespace App\Services;

use App\Models\InventoryMovement;
use Illuminate\Support\Facades\Auth;

class InventoryMovementLogger
{
    public static function log(int $productId, string $type, int $quantity, ?string $reference = null): void
    {
        InventoryMovement::create([
            'product_id' => $productId,
            'type' => $type,
            'quantity' => $quantity,
            'reference' => $reference,
            'user_id' => Auth::id(),
        ]);
    }
}
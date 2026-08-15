<?php

namespace App\Http\Controllers;

use App\Models\InventoryMovement;
use Illuminate\Http\Request;

class InventoryMovementController extends Controller
{
    public function index(Request $request)
    {
        $movements = InventoryMovement::with(['product', 'user'])
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->when($request->date_from, fn($q) => $q->whereDate('created_at', '>=', $request->date_from))
            ->when($request->date_to, fn($q) => $q->whereDate('created_at', '<=', $request->date_to))
            ->orderBy('created_at', $request->order ?? 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('inventory.movements', compact('movements'));
    }
}
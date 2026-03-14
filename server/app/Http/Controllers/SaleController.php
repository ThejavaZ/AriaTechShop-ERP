<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('details')->get();
        return view('sales.index', compact('sales'));
    }

    public function show($id)
    {
        return Sale::with('details')->findOrFail($id);
    }

    public function store(Request $request)
    {
        // Validación básica
        $validated = $request->validate([
            'sale_date' => 'required|date',
        ]);

        $sale = Sale::create($validated);

        return response()->json($sale, 201);
    }

    public function destroy($id)
    {
        Sale::destroy($id);

        return response()->json([
            'message' => 'Venta eliminada correctamente'
        ]);
    }

    public function salesChart()
    {
        $sales = DB::table('sales')
            ->selectRaw('DATE(sale_date) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json($sales);
    }

    public function chartView()
    {
        return view('sales.chart');
    }
}
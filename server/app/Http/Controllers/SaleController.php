<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        return Sale::with('details')->get();
    }

    public function show($id)
    {
        return Sale::with('details')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $sale = Sale::create($request->all());
        return response()->json($sale, 201);
    }

    public function destroy($id)
    {
        Sale::destroy($id);
        return response()->json(['message' => 'Venta eliminada']);
    }

    public function salesChart()
{
    $sales = \DB::table('sales')
        ->selectRaw('DATE(sale_date) as date, COUNT(*) as total')
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    return response()->json($sales);
}
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;

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


public function chartView()
{
    return view('sales.chart');
}

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;

class SaleController extends Controller
{

    public function index()
{
    $sales = Sale::with('details')->get();
    return view('sales.index', compact('sales'));
}

public function show($id)
{
    $sale = Sale::with('details')->findOrFail($id);

    return view('sales.show', compact('sale'));
}

    public function edit($id)
    {
        return Sale::with('details')->findOrFail($id);
        return Sale::with('details')->findOrFail($id);
    }

public function update(Request $request, $id)
{
    $sale = Sale::findOrFail($id);

    $sale->customer_name = $request->customer_name;
    $sale->customer_phone = $request->customer_phone;
    $sale->customer_email = $request->customer_email;
    $sale->total_amount = $request->total_amount;

    $sale->save();

    return redirect()->route('sales.index')
        ->with('success', 'Venta actualizada');
}

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);

        $sale->delete();

        return redirect()->route('sales.index')
            ->with('success', 'Venta eliminada');
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
}
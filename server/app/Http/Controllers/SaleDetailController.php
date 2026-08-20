<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaleDetail;
use App\Exports\SaleDetailsExport;
use Maatwebsite\Excel\Facades\Excel;

class SaleDetailController extends Controller
{

     public function index()
{
    $details = SaleDetail::all();

    return view('sale_details.index', compact('details'));
}

public function show($id)
{
    $detail = SaleDetail::findOrFail($id);

    return view('sale_details.show', compact('detail'));
}

    public function edit($id)
    {
        $detail = SaleDetail::findOrFail($id);

        return view('sale_details.edit', compact('detail'));
    }

    public function update(Request $request, $id)
    {
        $detail = SaleDetail::findOrFail($id);

        $detail->update([
            'product_name' => $request->product_name,
            'quantity' => $request->quantity,
            'total_price' => $request->total_price
        ]);

        return redirect()->route('sale_details.index')
            ->with('success', 'Detalle actualizado');
    }

    public function report()
    {
        $details = SaleDetail::all();

        return view('sale_details.report', compact('details'));
    }
    public function exportExcel()
{
    return Excel::download(new SaleDetailsExport, 'sale_details_report.xlsx');
}
}
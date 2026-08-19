<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\InventoryExport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class InventoryController extends Controller
{
    public function create()
    {
        return view('inventory.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'description' => 'nullable|string'
        ]);

        Inventory::create($validated);

        return redirect()->back()
            ->with('success', 'Producto registrado correctamente');
    }

    public function index(Request $request)
    {
        $search   = $request->input('search');
        $category = $request->input('category');
        $sort     = $request->input('sort', 'name');
        $order    = $request->input('order', 'asc');

        $products   = Inventory::buscar($search, $category, $sort, $order);
        $categories = Inventory::obtenerCategorias();

        return view('inventory.index', compact('products', 'categories', 'search', 'category', 'sort', 'order'));
    }

    public function edit(int $id)
    {
        $product = Inventory::findOrFail($id);

        return view('inventory.edit', compact('product'));
    }

    public function restock()
    {
        $products = Inventory::all();

        return view('inventory.restock', compact('products'));
    }

    public function storeRestock(Request $request)
    {
        $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'cantidad' => 'required|integer|min:1'
        ]);

        Inventory::registrarRestock(
            $request->inventory_id,
            $request->cantidad
        );

        return redirect()->route('inventory.index')
            ->with('success', 'Restock registrado correctamente');
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'description' => 'nullable|string'
        ]);

        Inventory::actualizarProducto($id, $validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Producto actualizado correctamente');
    }

    public function report(Request $request)
    {
        $category      = $request->input('category');
        $soloStockBajo = $request->boolean('stock_bajo');
 
        $products   = Inventory::obtenerParaReporte($category, $soloStockBajo);
        $categories = Inventory::obtenerCategorias();
 
        return view('inventory.report', compact('products', 'categories', 'category', 'soloStockBajo'));
    }
 
    public function exportPdf(Request $request)
    {
        $category      = $request->input('category');
        $soloStockBajo = $request->boolean('stock_bajo');
        $products      = Inventory::obtenerParaReporte($category, $soloStockBajo);
 
        $pdf = Pdf::loadView('inventory.report-pdf', compact('products', 'category', 'soloStockBajo'))
            ->setPaper('a4', 'landscape');
 
        return $pdf->download('reporte-inventario-' . now()->format('Y-m-d') . '.pdf');
    }
 
    public function exportExcel(Request $request)
    {
        $category      = $request->input('category');
        $soloStockBajo = $request->boolean('stock_bajo');
        $filename      = 'reporte-inventario-' . now()->format('Y-m-d') . '.xlsx';
 
        return Excel::download(new InventoryExport($category, $soloStockBajo), $filename);
    }
 
    public function exportWord(Request $request)
    {
        $category      = $request->input('category');
        $soloStockBajo = $request->boolean('stock_bajo');
        $products      = Inventory::obtenerParaReporte($category, $soloStockBajo);
 
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
 
        $section->addText(
            'Reporte de Inventario — ' . now()->format('d/m/Y H:i'),
            ['bold' => true, 'size' => 16]
        );
        $section->addTextBreak(1);
 
        $table = $section->addTable([
            'borderSize'  => 6,
            'borderColor' => '999999',
            'cellMargin'  => 80,
        ]);
 
        $table->addRow();
        foreach (['Nombre', 'Categoría', 'Precio', 'Stock', 'Stock Mín.', 'Estado'] as $header) {
            $cell = $table->addCell(2000, ['bgColor' => '1e293b']);
            $cell->addText($header, ['bold' => true, 'size' => 10, 'color' => 'FFFFFF']);
        }
 
        foreach ($products as $product) {
            $estado  = $product->stock <= $product->min_stock ? 'Bajo stock' : 'Normal';
            $bgColor = $product->stock <= $product->min_stock ? 'FFE5E5' : 'FFFFFF';
            $table->addRow();
            foreach ([
                $product->name,
                $product->category,
                '$' . number_format($product->price, 2),
                $product->stock,
                $product->min_stock,
                $estado,
            ] as $value) {
                $cell = $table->addCell(2000, ['bgColor' => $bgColor]);
                $cell->addText((string) $value, ['size' => 9]);
            }
        }
 
        $filename = 'reporte-inventario-' . now()->format('Y-m-d') . '.docx';
        $tmpPath  = storage_path('app/' . $filename);
 
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tmpPath);
 
        return response()->download($tmpPath, $filename)->deleteFileAfterSend(true);
    }
}
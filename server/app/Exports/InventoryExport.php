<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InventoryExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected ?string $category;
    protected bool $soloStockBajo;

    public function __construct(?string $category = null, bool $soloStockBajo = false)
    {
        $this->category      = $category;
        $this->soloStockBajo = $soloStockBajo;
    }

    public function collection()
    {
        return Inventory::select('name', 'category', 'price', 'stock', 'min_stock')
            ->when($this->category,      fn($q) => $q->where('category', $this->category))
            ->when($this->soloStockBajo, fn($q) => $q->whereColumn('stock', '<=', 'min_stock'))
            ->orderBy('name')
            ->get()
            ->map(fn($p) => [
                'Nombre'      => $p->name,
                'Categoría'   => $p->category,
                'Precio'      => '$' . number_format($p->price, 2),
                'Stock'       => $p->stock,
                'Stock Mín.'  => $p->min_stock,
                'Estado'      => $p->stock <= $p->min_stock ? 'Bajo stock' : 'Normal',
            ]);
    }

    public function headings(): array
    {
        return ['Nombre', 'Categoría', 'Precio', 'Stock', 'Stock Mín.', 'Estado'];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Inventario';
    }
}
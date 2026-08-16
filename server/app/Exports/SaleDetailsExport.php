<?php

namespace App\Exports;

use App\Models\SaleDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SaleDetailsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return SaleDetail::select(
            'id',
            'product_name',
            'quantity',
            'total_price'
        )->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Producto',
            'Cantidad',
            'Total'
        ];
    }
}
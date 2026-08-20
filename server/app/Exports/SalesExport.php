<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Sale::select(
            'invoice_number',
            'customer_name',
            'total_amount',
            'sale_date'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Factura',
            'Cliente',
            'Total',
            'Fecha'
        ];
    }
}
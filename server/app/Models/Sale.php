<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'invoice_number',
        'sale_date',
        'customer_name',
        'customer_phone',
        'customer_email',
        'subtotal',
        'tax_amount',
        'total_amount',
        'payment_method'
    ];

    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\HasMany;
=======
>>>>>>> 92925bac025897d0d44f08032ee7ee60e5a198dc

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

<<<<<<< HEAD
    protected $casts = [
        'sale_date' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2'
    ];

    // Relación con detalles de venta
    public function details()
    {
        return $this->hasMany(\App\Models\SaleDetail::class, 'sale_id');
     }

    
=======
    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }
>>>>>>> 92925bac025897d0d44f08032ee7ee60e5a198dc
}
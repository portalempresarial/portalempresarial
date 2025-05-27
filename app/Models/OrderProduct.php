<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model {
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function product() {
        return $this->belongsTo(Product::class);
    }
    
    public function wholesalerProduct() {
        return $this->belongsTo(WholesalerProduct::class)->withDefault([
            'name' => 'Producto no disponible',
            'sku' => 'SKU no disponible',
            'price' => 0
        ]);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }
}

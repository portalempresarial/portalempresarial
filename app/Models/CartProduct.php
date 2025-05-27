<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model {
    use HasFactory;

    protected $guarded = []; 

    public $timestamps = false;

    public $table = "user_cart_products";

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function wholesalerProduct() {
        return $this->belongsTo(WholesalerProduct::class);
    }
    
    // Helper method to get the name of the product regardless of its type
    public function getProductNameAttribute() {
        return $this->product_id 
            ? $this->product->label 
            : ($this->wholesaler_product_id ? $this->wholesalerProduct->name : 'Producto desconocido');
    }
    
    // Helper method to get the price of the product regardless of its type
    public function getProductPriceAttribute() {
        return $this->product_id 
            ? $this->product->price 
            : ($this->wholesaler_product_id ? $this->wholesalerProduct->price : 0);
    }
}

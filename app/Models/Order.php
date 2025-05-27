<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    use HasFactory;

    protected $guarded = []; 

    public function seller() {
        return $this->belongsTo(Company::class, 'seller_company_id');
    }
    
    public function wholesaler() {
        return $this->belongsTo(Wholesaler::class);
    }

    public function buyer() {
        return $this->belongsTo(Company::class, 'buyer_company_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function products() {
        return $this->hasMany(OrderProduct::class);
    }
    
    // Helper method to determine if this order is from a wholesaler
    public function getIsWholesalerOrderAttribute() {
        return !is_null($this->wholesaler_id);
    }
    
    // Get all delivery notes associated with this order
    public function deliveryNotes() {
        return $this->hasMany(DeliveryNote::class);
    }
    
    // Helper method to get the seller name (company or wholesaler)
    public function getSellerNameAttribute() {
        return $this->wholesaler_id 
            ? $this->wholesaler->name 
            : ($this->seller ? $this->seller->name : 'Desconocido');
    }
}

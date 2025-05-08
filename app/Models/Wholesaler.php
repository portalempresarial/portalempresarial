<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wholesaler extends Model {
    use HasFactory;

    protected $guarded = []; 

    public $table = "wholesalers"; 

    public function center() {
        return $this->belongsTo(Center::class);
    }

    public function companyWholesalers() {
        return $this->hasMany(CompanyWholesaler::class);
    }
    
    public function categories() {
        return $this->belongsToMany(ProductCategory::class, 'wholesaler_product_categories', 'wholesaler_id', 'product_category_id')
            ->withTimestamps();
    }
    
    public function products() {
        return $this->hasMany(WholesalerProduct::class);
    }
}

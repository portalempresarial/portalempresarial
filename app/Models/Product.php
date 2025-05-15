<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory;

    public $table = "products"; 

    protected $guarded = []; 

    public function category() {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id'); 
    }

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'id'); 
    }
    
    public function stocks() {
        return $this->hasMany(CompanyProductStock::class);
    }
    
    public function stockForCompany($companyId) {
        return $this->stocks()->where('company_id', $companyId)->first();
    }
    
    public function hasStockForCompany($companyId, $quantity = 1) {
        $stock = $this->stockForCompany($companyId);
        return $stock && $stock->stock >= $quantity;
    }
}

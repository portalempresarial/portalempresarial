<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model {
    use HasFactory;

    protected $guarded = [];

    public function center() {
        return $this->belongsTo(Center::class);
    }

    public function teachers() {
        return $this->hasMany(CompanyTeacher::class);
    }

    public function marketQuestions() {
        return $this->hasMany(CompanyMarket::class);
    }

    public function employees() {
        return $this->hasMany(CompanyEmployee::class);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function productCategories() {
        return $this->hasMany(ProductCategory::class);
    }

    public function companyWholesalers() {
        return $this->hasMany(CompanyWholesaler::class);
    }

    public function wholesalers() {
        return $this->belongsToMany(Wholesaler::class, 'company_wholesalers', 'company_id', 'wholesaler_id');
    }
    
    public function productStocks() {
        return $this->hasMany(CompanyProductStock::class);
    }
    
    public function pendingDeliveries() {
        return $this->hasMany(PendingWholesalerDelivery::class);
    }
}

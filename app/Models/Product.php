<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory;

    public $table = "products"; 

    protected $guarded = [];
    
    protected $appends = ['stock'];

    public function category() {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id'); 
    }

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'id'); 
    }

    public function getStockAttribute()
    {
        return $this->attributes['stock'] ?? 0;
    }
}
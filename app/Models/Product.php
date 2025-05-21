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
    
    /**
     * Get the stock for the current product based on the company context
     */
    public function getStockAttribute()
    {
        // Intentar obtener el company_id del contexto actual
        $companyId = null;
        
        // Si estamos en un contexto Livewire que tiene la propiedad company
        if (app()->has('livewire.instance') && app('livewire.instance') && property_exists(app('livewire.instance'), 'company')) {
            $companyId = app('livewire.instance')->company->id;
        }
        
        if (!$companyId) {
            // Si no tenemos un company_id, devolver 0 como stock predeterminado
            return 0;
        }
        
        $stock = $this->stockForCompany($companyId);
        return $stock ? $stock->stock : 0;
    }
}

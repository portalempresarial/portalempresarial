<?php

namespace App\Livewire\Sections\Authorized;

use App\Models\Wholesaler;
use App\Models\WholesalerProduct;
use Livewire\Component;
use Livewire\WithPagination;

class WholesalerProducts extends Component
{
    use WithPagination;

    public $wholesaler;
    public $wholesalerId;
    public $filter = '';
    public $categoryFilter = null;
    public $categories = [];    public function mount($id)
    {
        $this->wholesalerId = $id;
        $this->wholesaler = Wholesaler::with('categories')->findOrFail($id);
        $this->categories = $this->wholesaler->categories->unique('id');
    }

    public function clearFilters()
    {
        $this->filter = '';
        $this->categoryFilter = null;
        $this->resetPage();
    }

    public function filterByCategory($categoryId)
    {
        $this->categoryFilter = $categoryId;
        $this->resetPage();
    }

    public function render()
    {
        $query = WholesalerProduct::where('wholesaler_id', $this->wholesalerId)
            ->where('name', 'like', '%' . $this->filter . '%');
        
        if ($this->categoryFilter) {
            $query->where('category_id', $this->categoryFilter);
        }
        
        $products = $query->orderBy('id')->paginate(12);
        
        return view('livewire.sections.authorized.wholesaler-products', [
            'products' => $products
        ]);
    }
}

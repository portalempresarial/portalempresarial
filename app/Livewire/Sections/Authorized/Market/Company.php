<?php

namespace App\Livewire\Sections\Authorized\Market;

use Livewire\Component;
use App\Models\Company as CompanyModel;
use App\Models\Product;
use Livewire\Attributes\Url;
use App\Models\CartProduct;

class Company extends Component
{
    #[Url]
    public $filter, $category;

    public $company, $selected_product, $selected_counter = 1;

    protected $products = [];

    public function addToCart()
    {
        // Verificar que haya stock suficiente
        if ($this->selected_product->stock < $this->selected_counter) {
            toastr()->error('No hay suficiente stock disponible. Stock actual: ' . $this->selected_product->stock);
            return;
        }
        
        $onCart = CartProduct::where('user_id', auth()->user()->id)->where('product_id', $this->selected_product->id)->first();

        if (!$onCart) {
            CartProduct::create([
                'user_id' => auth()->user()->id,
                'product_id' => $this->selected_product->id,
                'amount' => $this->selected_counter
            ]);
        } else {
            // Verificar que no se exceda el stock disponible considerando lo que ya está en el carrito
            $totalRequestedAmount = $onCart->amount + $this->selected_counter;
            if ($totalRequestedAmount > $this->selected_product->stock) {
                toastr()->error('No hay suficiente stock disponible. Ya tienes ' . $onCart->amount . ' en el carrito y solo hay ' . $this->selected_product->stock . ' disponibles.');
                return;
            }
            
            $onCart->update([
                'amount' => $totalRequestedAmount
            ]);
        }

        toastr()->success('Producto añadido al carrito.');

        $this->reset(['selected_product', 'selected_counter']);
    }

    public function updatedSelectedCounter($value)
    {
        $this->selected_counter = max(1, (int)$value);
    }

    public function validateCounter()
    {
        $this->selected_counter = max(1, (int) $this->selected_counter);
    }


    public function mount($company, $product = false)
    {
        $this->company = CompanyModel::where('name', str_replace('-', ' ', $company))->firstOrFail();

        if ($product) {
            $this->selected_product = Product::where('label', str_replace('-', ' ', $product))->firstOrFail();
        }
    }

    public function render()
    {
        if ($this->company) {
            $queryBuilder = Product::query();

            if ($this->filter) {
                $queryBuilder->where('label', 'LIKE', '%' . $this->filter . '%');
            }

            if ($this->category) {
                $queryBuilder->where('category_id', $this->category);
            }

            // Solo mostrar productos con stock
            $queryBuilder->where('company_id', $this->company->id)
                         ->where('stock', '>', 0);

            $this->products = $queryBuilder->get();
        }

        return view('livewire.sections.authorized.market.company');
    }
}

<?php

namespace App\Livewire\Sections\Authorized\Market;

use Livewire\Component;
use App\Models\Company as CompanyModel;
use App\Models\Product;
use Livewire\Attributes\Url;
use App\Models\CartProduct;
use App\Models\CompanyProductStock;

class Company extends Component
{
    #[Url]
    public $filter, $category;

    public $company, $selected_product, $selected_counter = 1;

    protected $products = [];

    public function addToCart()
    {
        // Recargar el producto con sus stock actualizados para esta compañía
        $this->selected_product->refresh();
        $this->selected_product->refresh();
        if ($this->selected_product->stock < $this->selected_counter) {
            toastr()->error('No hay suficiente stock disponible. Stock actual: ' . $this->selected_product->stock);
            return;
        }

        $onCart = CartProduct::where('user_id', auth()->user()->id)
            ->where('product_id', $this->selected_product->id)
            ->first();

        if (!$onCart) {
            CartProduct::create([
                'user_id' => auth()->user()->id,
                'product_id' => $this->selected_product->id,
                'amount' => $this->selected_counter
            ]);
        } else {
            // Verificar que no se exceda el stock disponible considerando lo que ya está en el carrito
            $totalRequestedAmount = $onCart->amount + $this->selected_counter;
            if ($totalRequestedAmount > $productStock->stock) {
                toastr()->error('No hay suficiente stock disponible. Ya tienes ' . $onCart->amount . ' en el carrito y solo hay ' . $productStock->stock . ' disponibles.');
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

    public function debugProductStock($productId = null)
    {
        if (!$productId && $this->selected_product) {
            $productId = $this->selected_product->id;
        }

        if (!$productId) {
            return null;
        }

        $product = Product::find($productId);
        if (!$product) {
            return ['error' => 'Producto no encontrado'];
        }

        $stock = CompanyProductStock::where('product_id', $productId)
            ->where('company_id', $this->company->id)
            ->first();

        return [
            'product_id' => $productId,
            'company_id' => $this->company->id,
            'stock_record' => $stock,
            'stock_amount' => $stock ? $stock->stock : 0
        ];
    }

    public function mount($company, $product = false)
    {
        $this->company = CompanyModel::where('name', str_replace('-', ' ', $company))->firstOrFail();

        if ($product) {
            $this->selected_product = Product::where('label', str_replace('-', ' ', $product))
                ->where('company_id', $this->company->id)
                ->firstOrFail();
        }
    }

    public function render()
    {
        if ($this->company) {
            app()->instance('livewire.instance', $this);

            $queryBuilder = Product::query();

            if ($this->filter) {
                $queryBuilder->where('label', 'LIKE', '%' . $this->filter . '%');
            }

            if ($this->category) {
                $queryBuilder->where('category_id', $this->category);
            }

            $queryBuilder->where('company_id', $this->company->id);

            $this->products = $queryBuilder->get();

            if ($this->selected_product) {
                $this->selected_product->refresh();
            }
        }

        return view('livewire.sections.authorized.market.company');
    }
}

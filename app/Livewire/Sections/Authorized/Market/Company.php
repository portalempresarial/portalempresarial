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

    public $company, $selected_product, $selected_counter = 1, $successMessage;

    protected $products = [];

    public function addToCart()
    {
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
            $totalRequestedAmount = $onCart->amount + $this->selected_counter;
            if ($totalRequestedAmount > $this->selected_product->stock) {
                toastr()->error('No hay suficiente stock disponible. Ya tienes ' . $onCart->amount . ' en el carrito y solo hay ' . $this->selected_product->stock . ' disponibles.');
                return;
            }
            $onCart->update([
                'amount' => $totalRequestedAmount
            ]);
        }

        $this->successMessage = '¡Producto añadido correctamente a la cesta!';
        $this->selected_counter = 1;
    }

    public function updatedSelectedCounter($value)
    {
        $this->selected_counter = max(1, (int)$value);
    }

    public function validateCounter()
    {
        if ($this->selected_product) {
            $max = $this->selected_product->stock;
            if ($this->selected_counter > $max) {
                $this->selected_counter = $max;
            }
            if ($this->selected_counter < 1) {
                $this->selected_counter = 1;
            }
        }
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

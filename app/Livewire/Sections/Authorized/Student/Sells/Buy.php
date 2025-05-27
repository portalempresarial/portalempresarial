<?php

namespace App\Livewire\Sections\Authorized\Student\Sells;
use App\Models\Order; 
use Livewire\WithPagination;
use Livewire\Component;

class Buy extends Component {
    protected $orders = []; 

    public function render() {
        $this->orders = Order::where('buyer_company_id', auth()->user()->current_company)
            ->whereNull('wholesaler_id') // Solo compras a otras empresas, no a mayoristas
            ->orderBy('created_at', 'desc')
            ->paginate(15); 
            
        return view('livewire.sections.authorized.student.sells.buy');
    }
}

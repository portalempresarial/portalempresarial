<?php

namespace App\Livewire\Sections\Authorized\Teacher;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use Livewire\Component;
use App\Models\Order;
use App\Models\OrderProduct;

class Companies extends Component {
    protected $companies; 

    public $filter, $creating;
    public $social_denomination, $name, $sector, $form_level; 

    public function handleCreateModal() {
        $this->restoreParams(); 
        $this->creating = true; 
    }

    public function restoreParams() {
        $this->reset(['social_denomination', 'name', 'sector', 'form_level']);
    }


    protected $rules = [
        'social_denomination' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]+$/u',
        'name' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]+$/u',
        'sector' => 'required|string|max:255',
        'form_level' => 'required|string|max:255',
    ];

    protected $messages = [
        'social_denomination.required' => 'El campo nombre social es requerido.',
        'social_denomination.string' => 'El campo nombre social debe ser una cadena de caracteres.',
        'social_denomination.max' => 'El campo nombre social no debe exceder los 255 caracteres.',
        'social_denomination.regex' => 'El campo nombre social no puede contener acentos, caracteres especiales ni guiones.',
        'name.required' => 'El campo nombre es requerido.',
        'name.string' => 'El campo nombre debe ser una cadena de caracteres.',
        'name.regex' => 'El campo nombre no puede contener acentos, caracteres especiales ni guiones.',
        'name.max' => 'El campo nombre no debe exceder los 255 caracteres.',
        'sector.required' => 'El campo sector es requerido.',
        'sector.string' => 'El campo sector debe ser una cadena de caracteres.',
        'sector.max' => 'El campo sector no debe exceder los 255 caracteres.',
        'form_level.required' => 'El campo educación es requerido.',
        'form_level.string' => 'El campo educación debe ser una cadena de caracteres.',
        'form_level.max' => 'El campo educación no debe exceder los 255 caracteres.',
    ];

    public function create() {
        $this->validate();

        Company::create([
            'social_denomination' => $this->social_denomination,
            'name' => str_replace(' ', '-', $this->name),
            'sector' => $this->sector,
            'form_level' => $this->form_level,
            'center_id' => Auth::user()->center_id,
        ]);

        $this->creating = false;
        toastr()->success('Empresa creada con éxito.', '¡Éxito!');
    }

    public function render() {
        $this->companies = Company::where('center_id', Auth::user()->center_id)->where('name', 'LIKE', '%' . $this->filter . '%')->get(); 
        
        return view('livewire.sections.authorized.teacher.companies');
    }

    public function removeCompany(string $id) {
        $company = Company::findOrFail($id);

        $orders = Order::where('buyer_company_id', $company->id)
            ->orWhere('seller_company_id', $company->id)
            ->get();

        foreach ($orders as $order) {
            OrderProduct::where('order_id', $order->id)->delete();
            $order->delete(); // Eliminar la orden correctamente
        }

        $company->delete();
    }

}

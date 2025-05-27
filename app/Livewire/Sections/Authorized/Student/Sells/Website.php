<?php

namespace App\Livewire\Sections\Authorized\Student\Sells;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Company; 
use Livewire\WithFileUploads;
use App\Models\Wholesaler;
use App\Models\CompanyWholesaler;

class Website extends Component {
    use WithFileUploads;
    public $website, $company;
    public $iconImage;
    public $wholesalers = [];
    public $selectedWholesaler;

    public function save() {
        $this->validate([
            'website' => 'required|url'
        ], [
            'website.required' => 'El campo página web es obligatorio', 
            'website.url' => 'El campo página web debe ser una URL válida'
        ]);

        try {
            $this->company->website = $this->website; 
            $this->company->save(); 

            toastr()->success('La página web se ha guardado correctamente', ['title' => '¡Éxito!']);
        } catch (\Throwable $th) {
            toastr()->error('Ocurrió un error al guardar la página web', ['title' => '¡Error!']);
        } 
    }

    public function updatedIconImage() {
        $this->validate([
            'iconImage' => 'required|image|max:1024',
        ], [
            'iconImage.required' => 'Debes seleccionar una imagen',
            'iconImage.image' => 'El archivo debe ser una imagen',
            'iconImage.max' => 'La imagen no debe superar 1MB',
        ]);

        $this->iconImage->store('companies', 'public');
        $this->company->icon = $this->iconImage->hashName();
        $this->company->save();
        session()->flash('icon_success', 'Icono actualizado correctamente.');
    }

    public function mount() {
        $this->company = Company::find(Auth::user()->current_company); 
        $this->website = $this->company->website; 

        // Obtener todos los mayoristas
        $this->wholesalers = Wholesaler::with('sector')->get();

        // Obtener el mayorista asignado (si existe)
        $assigned = CompanyWholesaler::where('company_id', $this->company->id)->first();
        $this->selectedWholesaler = $assigned ? $assigned->wholesaler_id : null;
    }

    public function assignWholesaler() {
        if (!$this->selectedWholesaler) {
            toastr()->error('Debes seleccionar un mayorista.');
            return;
        }

        // Eliminar asignaciones previas
        CompanyWholesaler::where('company_id', $this->company->id)->delete();

        // Asignar el nuevo mayorista
        CompanyWholesaler::create([
            'company_id' => $this->company->id,
            'wholesaler_id' => $this->selectedWholesaler,
        ]);

        toastr()->success('Mayorista asignado correctamente.');
    }

    public function render() {
        $this->company = Company::find(Auth::user()->current_company); 

        return view('livewire.sections.authorized.student.sells.website');
    }
}

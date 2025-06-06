<?php

namespace App\Livewire\Sections\Authorized\Teacher;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 
use App\Models\VerificationCode; 
use Illuminate\Support\Facades\Hash;
use App\Models\Role; 
use Illuminate\Support\Facades\Mail;
use App\Mail\GenericEmail;

class Users extends Component {
    use WithPagination;

    protected $users; 
    public $userFilter, $roles, $deleting = false;
    public $email, $role, $inviting;

    public function restoreParams() {
        $this->reset(['email', 'role']);
    }

    public function inviteContact() {
        $this->restoreParams(); 
        $this->inviting = true; 
    }

    public function confirmInvite() {
        if(!$this->email && strlen($this->email) <= 0) {
            toastr()->error("La dirección de correo es inválida");
            return; 
        } 

        if(!$this->role) return; 

        $code = rand(100000, 999999); 

        $wasSend = VerificationCode::create([
            'center_id' => Auth::user()->center_id,
            'role_id' => $this->role,
            'code' => $code, 
            'usages' => 1
        ]);

        if($wasSend) {
            $this->inviting = false; 

            try {
                $emailSend = Mail::to($this->email)->send(new GenericEmail(
                    "Invitación al Portal Empresarial", 
                    "Buenos días, el usuario <strong>" . Auth::user()->name . "</strong> te ha invitado a unirte al <strong>Portal Empresarial</strong>. Para ello, debes registrarte en el siguiente enlace: " . route('register') . " y utilizar el siguiente código de verificación: <strong>" . $code . "</strong>"
                ));
                
                toastr()->success("Se ha enviado un correo electrónico con el código de verificación", '¡Éxito!');
                return;
            } catch (\Throwable $th) {
                toastr()->error("Ha ocurrido un error al enviar el correo electrónico");
            }
        } else {
            toastr()->error("Ha ocurrido un error al enviar el correo electrónico");
            return; 
        }
    }

    public function accept($user_id) {
        $user = User::find($user_id); 

        $user->update([
            'status' => 'active'
        ]);

        toastr()->success("El usuario ha sido aceptado", '¡Éxito!');
    }

    public function delete($user_id) {
        if(!$this->deleting) {
            $this->deleting = $user_id; 
        } else {
            if($user_id == $this->deleting) {
                $this->deleting = false; 
                User::find($user_id)->delete();
            } else {
                $this->deleting = $user_id;
            }
        }
    }

    public function mount() {
        $this->roles = Role::where('name', '!=', 'Administrador')->get();
    }

    public function updatingSearch() {
        $this->resetPage();
    }
    
    public function render() { 

        if($this->userFilter) $this->updatingSearch();
        
        $this->users = User::where('name', 'like', '%' . $this->userFilter . '%')
        ->when(Auth::user()->role->name == 'Profesor', function ($query) {
            return $query->where('center_id', Auth::user()->center_id);
        })
        ->paginate(10);

        return view('livewire.sections.authorized.teacher.users');
    }
}

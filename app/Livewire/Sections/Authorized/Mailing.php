<?php

namespace App\Livewire\Sections\Authorized;

use App\Models\Mails;
use App\Models\MailsUser;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Carbon\Carbon;

class Mailing extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $selectedEmail = null;
    public $newEmail = false;
    public $showDeleted = false;

    public $subject, $body, $recipients = "";

    public function selectEmail($emailId)
    {
        $this->selectedEmail = Mails::find($emailId);
        $this->newEmail = false;

        if ($this->selectedEmail) {
            $mailUser = MailsUser::where('message_id', $this->selectedEmail->id)
                ->where('recipient_id', Auth::id())
                ->whereNull('readt_at')
                ->first();

            if ($mailUser) {
                $mailUser->touch('readt_at');
            }
        }
    }

    public function toggleNewEmail()
    {
        $this->newEmail = true;
        $this->selectedEmail = null;
        $this->reset(['subject', 'body', 'recipients']);
    }

    public function submitEmail()
    {
        $this->validate([
            'recipients' => 'required|string',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $email = Mails::create([
            'subject' => $this->subject,
            'body' => $this->body,
            'sender_id' => Auth::id(),
        ]);

        $recipientsEmails = array_map('trim', explode(',', $this->recipients));

        foreach ($recipientsEmails as $emailAddress) {
            $user = User::where('email', $emailAddress)->first();

            if ($user) {
                MailsUser::create([
                    'message_id' => $email->id,
                    'recipient_id' => $user->id,
                ]);
            }
        }

        $this->reset(['subject', 'body', 'newEmail']);
        session()->flash('message', 'El email ha sido enviado correctamente.');
    }

    public function deleteEmail(Mails $email)
    {
        $this->newEmail = true;
        $this->selectedEmail = null;

        $mailUser = MailsUser::where('message_id', $email->id)
            ->where('recipient_id', Auth::id())
            ->first();

        if ($mailUser) {
            $mailUser->delete();
        }
    }

    public function forceDeleteEmail(Mails $email)
    {
        $this->newEmail = true;
        $this->selectedEmail = null;

        $mailUser = MailsUser::withTrashed()
            ->where('message_id', $email->id)
            ->where('recipient_id', Auth::id())
            ->first();

        if ($mailUser) {
            $mailUser->forceDelete();
        }
    }

    public function toggleDeleted()
    {
        $this->showDeleted = !$this->showDeleted;
    }

    public function restoreEmail(Mails $email)
    {
        $mailUser = MailsUser::withTrashed()
            ->where('message_id', $email->id)
            ->where('recipient_id', Auth::id())
            ->first();

        if ($mailUser && $mailUser->trashed()) {
            $mailUser->restore();
        }
    }

    public function render()
    {
        $query = Mails::whereHas('recipients', function ($query) {
            $query->where('recipient_id', Auth::id());
        });

        if ($this->showDeleted) {
            $query->whereHas('recipients', function ($query) {
                $query->whereNotNull('deleted_at');
            });
        } else {
            $query->whereHas('recipients', function ($query) {
                $query->whereNull('deleted_at');
            });
        }

        $emails = $query->latest()->paginate(9);

        return view('livewire.sections.authorized.mailing', compact('emails'));
    }
}

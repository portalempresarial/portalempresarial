<?php

namespace App\Livewire\Sections\Authorized;

use App\Models\MailAttachment;
use App\Models\Mail;
use App\Models\MailsUser;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Mailing extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'tailwind';

    public $selectedEmail = null;
    public $newEmail = false;
    public $showDeleted = false;

    public $subject, $body, $recipients = "";
    public $attachments = [];

    public function selectEmail($emailId)
    {
        $this->selectedEmail = Mail::find($emailId);
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
        $this->reset(['subject', 'body', 'recipients', 'attachments']);
    }

    public function submitEmail()
    {
        $this->validate([
            'recipients' => 'required|string',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'attachments.*' => 'nullable|file|max:2048',
        ]);

        $email = Mail::create([
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

        if ($this->attachments) {
            foreach ($this->attachments as $file) {
                $path = $file->store('attachments', 'public');

                MailAttachment::create([
                    'mail_id' => $email->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                ]);
            }
        }

        $this->reset(['subject', 'body', 'newEmail']);
        session()->flash('message', 'El email ha sido enviado correctamente.');
    }

    public function deleteEmail(Mail $email)
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

    public function forceDeleteEmail(Mail $email)
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

    public function restoreEmail(Mail $email)
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
        $query = Mail::whereHas('recipients', function ($query) {
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

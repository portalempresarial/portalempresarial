<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Mail extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'subject',
        'body'
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function  attachments()
    {
        return $this->hasMany(MailAttachment::class);
    }

    public function recipients(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'mails_users', 'message_id', 'recipient_id')
            ->withPivot('readt_at')
            ->withTimestamps();
    }
}

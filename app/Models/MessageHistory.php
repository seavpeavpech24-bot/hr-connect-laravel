<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class MessageHistory extends Model
{
    use HasFactory;

    protected $table = 'message_history';

    public $incrementing = false;
    protected $keyType = 'string';

    // FIXED: Disable timestamps since migration doesn't have created_at/updated_at
    public $timestamps = false;

    protected $fillable = [
        'sender_user_id',
        'applicant_id',
        'template_id',
        'recipient_email',
        'subject',
        'body',
        'send_status',
        'smtp_response',
        'attachments_json',
    ];

    protected $casts = [
        'id' => 'string',
        'sender_user_id' => 'string',
        'applicant_id' => 'string',
        'template_id' => 'string',
        'attachments_json' => 'array',
        'sent_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function senderUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class, 'applicant_id');
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(MessageTemplate::class, 'template_id');
    }
}
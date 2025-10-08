<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class MessageTemplate extends Model
{
    use HasFactory;

    protected $table = 'message_templates';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'template_type',
        'subject',
        'body',
        'created_by_user_id',
    ];

    protected $casts = [
        'id' => 'string',
        'created_by_user_id' => 'string',
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

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function messageHistories(): HasMany
    {
        return $this->hasMany(MessageHistory::class, 'template_id');
    }
}
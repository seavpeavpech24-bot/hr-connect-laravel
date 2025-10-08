<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ApplicantFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'file_path',
        'file_name',
        'file_type',
        'uploaded_by_user_id',
    ];

    // UUID settings
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string',
        'applicant_id' => 'string',
        'uploaded_by_user_id' => 'string',
        'uploaded_at' => 'datetime',
    ];

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by_user_id');
    }

    // Auto-generate UUID on creation
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}
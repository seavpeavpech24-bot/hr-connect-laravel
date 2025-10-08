<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str; // Add this import

class Applicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'applied_position_id',
        'status',
        'source',
        'notes',
    ];

    // UUID settings
    public $incrementing = false; // Disable auto-increment
    protected $keyType = 'string'; // Use string for UUID

    protected $casts = [
        'id' => 'string', // UUID
        'applied_position_id' => 'string', // UUID, nullable
        'phone' => 'string', // Nullable
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'applied_position_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(ApplicantFile::class, 'applicant_id');
    }

    public function messageHistory(): HasMany
    {
        return $this->hasMany(MessageHistory::class, 'applicant_id');
    }

    // Helper: Get status label for view
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'reviewed' => 'Reviewed',
            'rejected' => 'Rejected',
            'approved' => 'Approved',
            'interviewed' => 'Interviewed',
            default => 'Unknown',
        };
    }

    // Helper: Get status class for badges
    public function getStatusClassAttribute(): string
    {
        return match ($this->status) {
            'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            default => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
        };
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
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str; // Add this import for UUID generation

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    // UUID settings
    public $incrementing = false; // Disable auto-increment
    protected $keyType = 'string'; // Use string for UUID

    protected $casts = [
        'id' => 'string', // UUID
    ];

    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class, 'applied_position_id');
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
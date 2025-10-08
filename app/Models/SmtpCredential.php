<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SmtpCredential extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'smtp_credentials';

    protected $fillable = [
        'user_id',
        'smtp_host',
        'smtp_port',
        'smtp_secure',
        'smtp_email',
        'smtp_app_password_encrypted',
    ];

    // Relationship: Belongs to User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

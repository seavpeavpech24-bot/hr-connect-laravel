<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, HasUuids, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'full_name',
        'email',
        'company_name',
        'password_hash',
        'role',
        'profile_picture',
        'email_verified',
        'accepted_terms_and_privacy', // Added for terms/privacy acceptance
    ];

    protected $hidden = ['password_hash'];

    // Relationship: One User → One SMTP Credential
    public function smtpCredential()
    {
        return $this->hasOne(SmtpCredential::class, 'user_id');
    }
}
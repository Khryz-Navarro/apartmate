<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that are protected from mass assignment.
     * These fields control sensitive account operations and should only be modified
     * through controlled methods to prevent security vulnerabilities.
     *
     * @var list<string>
     */
    protected $guarded = [
        'deleted_at', // Laravel's soft delete field
        'id', // Primary key should not be mass assignable
        'email_verified_at', // Email verification status
        'remember_token', // Remember me token
        'created_at', // Timestamps
        'updated_at', // Timestamps
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Permanently delete the account
     */
    public function deleteAccount(): void
    {
        $this->forceDelete();
    }
}

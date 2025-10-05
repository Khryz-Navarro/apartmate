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
        'delete_requested_at',
        'delete_token',
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
            'delete_requested_at' => 'datetime',
        ];
    }

    /**
     * Request account deletion with grace period
     */
    public function requestDeletion(): string
    {
        $token = Str::random(32);
        
        $this->update([
            'delete_requested_at' => now(),
            'delete_token' => $token,
        ]);

        return $token;
    }

    /**
     * Cancel account deletion request
     */
    public function cancelDeletion(): void
    {
        $this->update([
            'delete_requested_at' => null,
            'delete_token' => null,
        ]);
    }

    /**
     * Check if account deletion is within grace period (7 days)
     */
    public function isWithinGracePeriod(): bool
    {
        if (!$this->delete_requested_at) {
            return false;
        }

        return $this->delete_requested_at->addDays(7)->isFuture();
    }

    /**
     * Permanently delete the account after grace period
     */
    public function permanentDelete(): void
    {
        $this->forceDelete();
    }
}

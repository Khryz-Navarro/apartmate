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
        'delete_requested_at',
        'delete_token',
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
            'delete_requested_at' => 'datetime',
        ];
    }

    /**
     * Request account deletion with grace period
     */
    public function requestDeletion(): string
    {
        // Check if deletion is already pending
        if ($this->delete_requested_at) {
            throw new \Exception('Account deletion is already pending.');
        }

        $token = Str::random(32);
        
        try {
            // Use direct property assignment to bypass mass assignment protection
            $this->delete_requested_at = now();
            $this->delete_token = $token;
            
            if (!$this->save()) {
                throw new \Exception('Failed to save deletion request.');
            }

            return $token;
        } catch (\Exception $e) {
            // Reset the fields if save failed
            $this->delete_requested_at = null;
            $this->delete_token = null;
            throw new \Exception('Failed to request account deletion: ' . $e->getMessage());
        }
    }

    /**
     * Cancel account deletion request
     */
    public function cancelDeletion(): void
    {
        if (!$this->delete_requested_at) {
            throw new \Exception('No pending account deletion found.');
        }

        try {
            // Use direct property assignment to bypass mass assignment protection
            $this->delete_requested_at = null;
            $this->delete_token = null;
            
            if (!$this->save()) {
                throw new \Exception('Failed to save cancellation request.');
            }
        } catch (\Exception $e) {
            throw new \Exception('Failed to cancel account deletion: ' . $e->getMessage());
        }
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

    /**
     * Check if the account deletion has expired and should be permanently deleted
     */
    public function hasExpiredDeletion(): bool
    {
        if (!$this->delete_requested_at) {
            return false;
        }

        return $this->delete_requested_at->addDays(7)->isPast();
    }

    /**
     * Validate if the provided token matches the user's delete token
     */
    public function validateDeleteToken(string $token): bool
    {
        return $this->delete_token === $token && !empty($this->delete_token);
    }

    /**
     * Process expired account deletions (static method for cleanup)
     */
    public static function processExpiredDeletions(): int
    {
        $expiredUsers = User::whereNotNull('delete_requested_at')
                           ->where('delete_requested_at', '<', now()->subDays(7))
                           ->get();

        $deletedCount = 0;
        foreach ($expiredUsers as $user) {
            try {
                $user->permanentDelete();
                $deletedCount++;
                \Log::info("Permanently deleted expired account: {$user->email}");
            } catch (\Exception $e) {
                \Log::error("Failed to delete expired account {$user->email}: " . $e->getMessage());
            }
        }

        return $deletedCount;
    }
}

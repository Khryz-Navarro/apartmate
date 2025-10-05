<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class AccountDeletionNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $token;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $recoveryUrl = route('recover-account', ['token' => $this->token]);
        $expiryDate = $this->user->delete_requested_at->addDays(7)->format('F j, Y \a\t g:i A');
        
        return (new MailMessage)
            ->subject('Account Deletion Requested - Action Required')
            ->greeting('Hello ' . $this->user->name . ',')
            ->line('We received a request to delete your ApartMate account.')
            ->line('Your account will be permanently deleted on **' . $expiryDate . '** unless you take action.')
            ->line('If you requested this deletion, you can ignore this email.')
            ->line('If you did NOT request this deletion, or if you changed your mind, click the button below to recover your account:')
            ->action('Recover My Account', $recoveryUrl)
            ->line('This recovery link will expire on ' . $expiryDate . '.')
            ->line('If you have any questions, please contact our support team.')
            ->salutation('Best regards, The ApartMate Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

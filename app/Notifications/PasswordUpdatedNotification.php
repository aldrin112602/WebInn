<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordUpdatedNotification extends Notification
{
    use Queueable;

    protected $newPassword, $username, $name, $loginUrl;

    public function __construct($newPassword, $username, $name, $type)
    {
        $this->newPassword = $newPassword;
        $this->username = $username;
        $this->name = $name;
        $this->loginUrl = "https://aquamarine-fish-440283.hostingersite.com/$type/login";
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Password Has Been Updated')
            ->greeting("Hello {$this->name},")
            ->line('Your password has been successfully updated.')
            ->line("**New Password:** {$this->newPassword}")
            ->line("**Username:** {$this->username}")
            ->action('Login Here', $this->loginUrl)
            ->line('Please keep this information secure and consider changing it periodically.')
            ->salutation('Best regards, WebInn Team');
    }
}

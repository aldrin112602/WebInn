<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AccountCreatedNotification extends Notification
{
    use Queueable;

    protected $password, $redirectUrl, $username;

    public function __construct($password, $type, $username)
    {
        $this->password = $password;
        $this->username = $username;
        $this->redirectUrl = "https://aquamarine-fish-440283.hostingersite.com/$type/login";
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Welcome to ' . config('app.name'))
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your account has been created successfully.')
            ->line('Username: ' . $this->username)
            ->line('Password: ' . $this->password)
            ->action('Login Now', url($this->redirectUrl))
            ->line('Please change your password after logging in.');
    }
}

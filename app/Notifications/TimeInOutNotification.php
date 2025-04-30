<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TimeInOutNotification extends Notification
{
    use Queueable;

    protected $studentName;
    protected $scanType;
    protected $time;
    protected $date;

    /**
     * Create a new notification instance.
     */
    public function __construct($studentName, $scanType, $time, $date)
    {
        $this->studentName = $studentName;
        $this->scanType = $scanType;
        $this->time = $time;
        $this->date = $date;
    }

    /**
     * Get the notification's delivery channels.
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
        return (new MailMessage)
            ->subject('Student ' . $this->scanType . ' Notification')
            ->greeting('Dear Parent/Guardian,')
            ->line("This is to inform you that your student, {$this->studentName}, has successfully completed a facial scan for {$this->scanType}.")
            ->line("Date: {$this->date}")
            ->line("Time: {$this->time}")
            ->line('If you have any concerns or questions, feel free to reach out.')
            ->salutation('Best regards,')
            ->line(config('app.name') . ' Attendance System');
    }
}

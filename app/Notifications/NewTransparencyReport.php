<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewTransparencyReport extends Notification
{
    use Queueable;

    protected $reportDate;

    /**
     * Create a new notification instance.
     *
     * @param string $reportDate
     */
    public function __construct($reportDate)
    {
        $this->reportDate = $reportDate;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail']; // Add 'database' if you want to store notifications
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = route('artist.reports.index');

        return (new MailMessage)
            ->subject('New Transparency Report Available')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('A new transparency report for ' . $this->reportDate . ' is now available.')
            ->action('View Report', $url)
            ->line('Thank you for being with us!');
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

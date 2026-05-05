<?php

namespace App\Notifications;

use App\Models\SupportTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SupportTicketResponded extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $ticket;

    public function __construct(SupportTicket $ticket)
    {
        $this->ticket = $ticket;
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
    public function toMail($notifiable)
    {
        $url = route('artist.support.show', $this->ticket->id);

        return (new MailMessage)
            ->subject('Your Support Ticket Has Been Updated')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your support ticket "' . $this->ticket->subject . '" has a new response.')
            ->action('View Ticket', $url)
            ->line('Thank you for using our application!');
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

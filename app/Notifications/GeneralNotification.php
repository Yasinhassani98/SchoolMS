<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Messages\MailMessage;

class GeneralNotification extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    protected $title;
    protected $message;
    protected $type;

    public function __construct($title, $message, $type )
    {
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'type' => $this->type,
        ];
    }

    public function toBroadcast($notifiable)
    {   
        return new BroadcastMessage([
            'title' => $this->title,
            'message' => $this->message,
            'notification_type' => $this->type, 
        ]);
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->title)
            ->line($this->message)
            ->action('View Notification', url('/notifications'))
            ->line('Thank you for using our application!');
    }
}

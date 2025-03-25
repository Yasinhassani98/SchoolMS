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

    public $title;
    public $message;
    public $data;
    public $type;

    public function __construct($title, $message, $data = [], $type )
    {
        $this->title = $title;
        $this->message = $message;
        $this->data = $data;
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
            'data' => $this->data,
            'type' => $this->type,
        ];
    }

    public function toBroadcast($notifiable)
    {   
        return new BroadcastMessage([
            'title' => $this->title,
            'message' => $this->message,
            'data' => $this->data,
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

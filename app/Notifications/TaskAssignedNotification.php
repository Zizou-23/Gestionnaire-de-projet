<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use APP\Models\Task;

class TaskAssignedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task)
{
    $this->task = $task;
}

public function via($notifiable)
{
    // On envoie par e-mail (et éventuellement par database, etc.)
    return ['mail'];
}

public function toMail($notifiable)
{
    return (new MailMessage)
        ->subject('Nouvelle tâche assignée')
        ->greeting('Bonjour ' . $notifiable->name)
        ->line('Une nouvelle tâche vous a été assignée : ' . $this->task->title)
        ->action('Voir la tâche', route('tasks.show', $this->task->id))
        ->line('Merci d’utiliser notre application !');
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

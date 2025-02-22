<?php

namespace App\Mail;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProjectInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $project;
    public $joinUrl;

    /**
     * Crée une nouvelle instance du Mailable.
     *
     * @param \App\Models\Project $project
     * @param string $joinUrl
     */
    public function __construct(Project $project, string $joinUrl)
    {
        $this->project = $project;
        $this->joinUrl = $joinUrl;
    }

    /**
     * Construire le message.
     */
    public function build()
    {
        return $this->subject("Invitation à rejoindre le projet : {$this->project->title}")
                    ->view('emails.project-invitation');
    }
}
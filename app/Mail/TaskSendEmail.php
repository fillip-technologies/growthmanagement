<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class TaskSendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $task;
    public $user_email;

    /**
     * Create a new message instance.
     */
    public function __construct($task, $user_email)
    {
        $this->task = $task;
        $this->user_email = $user_email;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Task Assigned'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'Emails.task',
            with: [
                'task' => $this->task,
                'user' => $this->user_email,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        $attachments = [];

        // attechment column JSON/array hona chahiye
        if (!empty($this->task->attechment)) {
            foreach ($this->task->attechment as $file) {
                $attachments[] = Attachment::fromPath(
                    storage_path('app/public/' . $file)
                );
            }
        }

        return $attachments;
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AssingtaskMail extends Mailable
{
    use Queueable, SerializesModels;

    public $task;
    public $user;

    public function __construct($task, $user)
    {
        $this->task = $task;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('New Task Assigned')
                    ->view('Emails.assingtaskmail')
                    ->with([
                        'task' => $this->task,
                        'user' => $this->user,
                    ]);
    }
}

<?php

namespace App\Listeners;


use App\Events\AssingneTaskEvent;
use App\Mail\AssingtaskMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AssingneTaskListener implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    public function handle(AssingneTaskEvent $event): void
    {
      Mail::to($event->user->email)
        ->send(new AssingtaskMail($event->user, $event->task));
    }
}

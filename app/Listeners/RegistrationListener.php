<?php

namespace App\Listeners;

use App\Events\RegistrationEvent;
use App\Mail\UserRegistrationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class RegistrationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RegistrationEvent $event): void
    {
        Mail::to($event->employee->email)->send(new UserRegistrationMail($event->employee, $event->plainPassword));
    }
}

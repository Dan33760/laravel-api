<?php

namespace App\Listeners;

use App\Mail\TestMarkdownMail;
use App\Events\UserProfilEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserprofilListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserProfilEvent  $event
     * @return void
     */
    public function handle(UserProfilEvent $event)
    {
        Mail::to($event->user->email)->send(new TestMarkdownMail($event->user));
    }
}

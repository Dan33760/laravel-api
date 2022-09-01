<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data = null;

    public function __construct(User $user)
    {
        $this->data = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('dansivyolo@gmail.com')
                    ->subject('Mon object personnaliser')
                    ->view('emails.test')
                    ->attachFromStorage('img/icon.png');
                    // ->attach(public_path('files/images/attachement/icon.png'));
    }
}

<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestMarkdownMail extends Mailable
{
    use Queueable, SerializesModels;

    public $url = 'http://127.0.0.1:8000/api';
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
        return $this->markdown('emails.markdown-test');
    }
}

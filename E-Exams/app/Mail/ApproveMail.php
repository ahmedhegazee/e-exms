<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApproveMail extends Mailable
{
    use Queueable, SerializesModels;
    public $message;
    /**
     * @var User
     */
    public $full_name;

    /**
     * Create a new message instance.
     * @param  $message
     * @param $full_name
     */
    public function __construct($message,$full_name)
    {
        $this->message=$message;
        $this->full_name=$full_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.approve');
    }
}

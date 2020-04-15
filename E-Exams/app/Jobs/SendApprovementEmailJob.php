<?php

namespace App\Jobs;

use App\Mail\ApproveMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendApprovementEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $message;
    private $full_name;
    private $email;

    /**
     * Create a new job instance.
     *
     * @param $message
     * @param $full_name
     * @param $email
     */
    public function __construct($message, $full_name,$email)
    {
        $this->full_name=$full_name;
        $this->message=$message;
        $this->email=$email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new ApproveMail($this->message,$this->full_name));
    }
}

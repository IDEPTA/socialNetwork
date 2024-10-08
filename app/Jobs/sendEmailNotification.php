<?php

namespace App\Jobs;

use App\Mail\NotificationMail;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class sendEmailNotification implements ShouldQueue
{
    use Queueable;
    private $users;
    private $title;
    private $text;
    /**
     * Create a new job instance.
     */
    public function __construct($users, $text, $title)
    {
        $this->users = $users;
        $this->title = $title;
        $this->text = $text;
    }

    /**
     * Execute the job.
     */
    public function handle(Exception $e): void
    {
        Log::info("джоб ", ["msg" => $e->getMessage()]);

        foreach ($this->users as $user) {
            Mail::to($user->email)->send(new NotificationMail($this->title, $this->text));
        }
    }
}

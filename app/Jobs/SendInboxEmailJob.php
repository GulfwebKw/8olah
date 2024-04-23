<?php

namespace App\Jobs;

use App\Mail\InboxEMail;
use App\Mail\RegisterEmail;
use App\Models\Inbox;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use function Symfony\Component\Translation\t;

class SendInboxEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $inbox_id;

    /**
     * Create a new job instance.
     */
    public function __construct($id)
    {
        $this->inbox_id = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $inbox = Inbox::query()->where('id', $this->inbox_id)->firstOrFail();
        foreach (User::query()->where('is_active',true)->where('is_admin' , true)->get() as $user) {
            if (filter_var($user->email, FILTER_VALIDATE_EMAIL))
                Mail::to($user->email)->send(new InboxEMail($inbox));
        }
    }
}

<?php

namespace App\Jobs;

use App\Mail\PostSubscriberNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendSubscriberEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $jobData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($jobData)
    {
        $this->jobData = $jobData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //logic for sending email
        Mail::to($this->jobData['email'])
            ->send(new PostSubscriberNotification($this->jobData['post']));
    }
}

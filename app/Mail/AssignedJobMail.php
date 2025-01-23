<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AssignedJobMail extends Mailable
{
    use Queueable, SerializesModels;

    public $jobData;
    /**
     * Create a new message instance.
     *
     * @param \App\Models\Job $jobData
     */
    public function __construct($jobData)
    {
        $this->jobData = $jobData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Job Won from HATS')
            ->view('email.assigned_job') // Email template
            ->with([
                'jobData' => $this->jobData,
            ]);
    }
}

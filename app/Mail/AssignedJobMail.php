<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AssignedJobMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $jobs;

    /**
     * Create a new message instance.
     *
     * @param $invoice
     * @param $jobs
     */
    public function __construct($invoice, $jobs)
    {
        $this->invoice = $invoice;
        $this->jobs = $jobs;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Job Won from HATS')
            ->view('email.assigned_job', ['invoice' => $this->invoice,'jobs' => $this->jobs]) // Email template
            ->attach(storage_path( "invoice_{$this->invoice->id}.pdf")) // Attach PDF
            ->with([
                'invoice' => $this->invoice,
                'jobs' => $this->jobs,
            ]);
    }
}

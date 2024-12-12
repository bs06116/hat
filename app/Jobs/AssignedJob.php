<?php

namespace App\Jobs;

use App\Mail\AssignedJobMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class AssignedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $job;
    public $driver;

    /**
     * Create a new job instance.
     *
     * @param $job
     */
    public function __construct($job, $driver)
    {
        $this->job = $job;
        $this->driver = $driver;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Mail::to($this->invoice->driver->email)->send(new InvoiceMail($this->invoice, $this->jobs));
         Mail::to($this->driver->email)->send(new AssignedJobMail($this->job, $this->driver));
    }
}

<?php

namespace App\Jobs;

use App\Mail\InvoiceMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendInvoiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $invoice;
    public $jobs;

    /**
     * Create a new job instance.
     *
     * @param $invoice
     */
    public function __construct($invoice, $jobs)
    {
        $this->invoice = $invoice;
        $this->jobs = $jobs;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Mail::to($this->invoice->driver->email)->send(new InvoiceMail($this->invoice, $this->jobs));
         Mail::to('iasimriaz@gmail.com')->send(new InvoiceMail($this->invoice, $this->jobs));
    }
}

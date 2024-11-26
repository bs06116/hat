<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Job;
use Carbon\Carbon;
use App\JobStatus;
use App\Models\Invoice;
use Log;
use Exception;

class CompletedJobs extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'completed:jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark jobs as completed based on end date and time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentDate = Carbon::now()->toDateString();
        $currentTime = Carbon::now()->toTimeString();   
        $completedJobs = Job::selectRaw('*, TIMESTAMPDIFF(MINUTE, start_time, end_time) as total_minutes')
            ->where('status', '!=', JobStatus::COMPLETED->value)
            ->whereHas('driversBids', function ($query) {
                $query->where('assigned', 1);
            })
            ->whereDate('end_date', '<', $currentDate)
            ->orWhere(function($query) use ($currentDate, $currentTime) {
                $query->whereDate('end_date', '=', $currentDate)
                      ->whereTime('end_time', '<=', $currentTime);
            })
            ->get();
        foreach ($completedJobs as $job) {
            try {
                // Retrieve the driver_id from the first assigned bid, if available
                $assignedBid = $job->driversBids->firstWhere('assigned', 1);
                $driverId = $assignedBid ? $assignedBid->driver_id : null;
        
                // Update job status to completed
                $job->update(['status' => JobStatus::COMPLETED]);
        
                // Calculate total hours and amount from minutes
                $totalMinutes = $job->total_minutes;
                $totalHours = $totalMinutes / 60; // Convert minutes to hours
                $totalAmount = $totalHours * $job->hourly_pay;
        
                // Check if driver_id is set
                if ($driverId) {
                    // Create invoice entry
                    Invoice::create([
                        'job_id' => $job->id,
                        'driver_id' => $driverId,
                        'total_hours' => $totalHours,
                        'total_amount' => $totalAmount,
                        'is_approved' => false,
                        'approved_by' => null,
                    ]);
                } else {
                    Log::info("Job ID {$job->id} has no driver assigned, skipping invoice creation.");
                }
            } catch (Exception $e) {
                Log::info("Failed to process job ID {$job->id}: " . $e->getMessage());
            }
        }
        
            
    }
}

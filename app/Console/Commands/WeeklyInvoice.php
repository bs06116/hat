<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Job;
use Carbon\Carbon;
use App\JobStatus;
use App\Models\Invoice;
use Log;
use Exception;
class WeeklyInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weekly:invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating weekly invoices...');

        $currentDate = Carbon::now()->toDateString();
        $currentTime = Carbon::now()->toTimeString();

        // Retrieve jobs completed based on end_date and end_time
        $completedJobs = Job::selectRaw('*, TIMESTAMPDIFF(MINUTE, start_time, end_time) as total_minutes')
           ->where('status', '!=', JobStatus::COMPLETED->value)
            ->whereHas('driversBids', function ($query) {
                $query->where('assigned', 1); // Filter only assigned bids
            })
            ->where(function ($query) use ($currentDate, $currentTime) {
                $query->whereDate('end_date', '<', $currentDate) // End date is before today
                    ->orWhere(function ($query) use ($currentDate, $currentTime) {
                        $query->whereDate('end_date', '=', $currentDate) // End date is today
                            ->whereTime('end_time', '<=', $currentTime); // End time is past
                    });
            })
            ->get();

        // Group jobs by driver
        $jobsByDriver = $completedJobs->groupBy(function ($job) {
            $assignedBid = $job->driversBids->firstWhere('assigned', 1);
            return $assignedBid ? $assignedBid->driver_id : null; // Group by driver_id
        });

        foreach ($jobsByDriver as $driverId => $jobs) {
            if (!$driverId) {
                Log::warning("Some completed jobs have no assigned driver.");
                continue;
            }

            try {
                // Total hours, amount, and job count for the driver
                $totalMinutes = $jobs->sum('total_minutes');
                $totalHours = $totalMinutes / 60; // Convert minutes to hours
                $totalAmount = 0;

                foreach ($jobs as $job) {
                    $job->update(['status' => JobStatus::COMPLETED]);
                    $totalAmount += ($job->total_minutes / 60) * $job->hourly_pay;
                }

                $jobCount = $jobs->count();

                // Create a single invoice for the driver
                Invoice::create([
                    'driver_id' => $driverId,
                    'total_hours' => $totalHours,
                    'total_amount' => $totalAmount,
                    'total_job' => $jobCount,
                    'is_approved' => false,
                    'approved_by' => null,
                ]);

                $this->info("Invoice created for driver ID {$driverId} with {$jobCount} jobs and {$totalHours} hours.");
            } catch (\Exception $e) {
                Log::error("Error generating invoice for driver ID {$driverId}: " . $e->getMessage());
            }
        }

        $this->info('Weekly invoices generated successfully.');
    }
}

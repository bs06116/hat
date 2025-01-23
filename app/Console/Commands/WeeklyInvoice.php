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
        Log::info('Generating weekly invoices...');

        $currentDate = Carbon::now()->toDateString();
        $currentTime = Carbon::now()->toTimeString();

        // Retrieve jobs completed based on end_date and end_time
        $completedJobs = Job::selectRaw('*')
           ->where('status', '!=', JobStatus::COMPLETED->value)
            ->whereHas('driversBids', function ($query) {
                $query->where('assigned', 1); // Filter only assigned bids
            })
            ->where(function ($query) use ($currentDate, $currentTime) {
                $query->whereDate('end_date', '<=', $currentDate) // End date is before today
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
                // $totalMinutes = $jobs->sum('total_minutes');
                $totalHours = 0;
                $totalAmount = 0;
                foreach ($jobs as $job) {
                    // Ensure the start date is in a valid format
                    $startDate = Carbon::parse($job->start_date);
                    $startTime = $job->start_time;
                    $startDateTime = $startDate->toDateString(); // Ensure it’s in the correct 'YYYY-MM-DD' format

                    // Only append start_time if it's not '00:00:00'
                    if ($startTime && $startTime !== '00:00:00') {
                        $startDateTime .= ' ' . $startTime;
                    }

                    // Ensure the end date is in a valid format
                    $endDate = Carbon::parse($job->end_date);
                    $endTime = $job->end_time;
                    $endDateTime = $endDate->toDateString(); // Ensure it’s in the correct 'YYYY-MM-DD' format

                    // Only append end_time if it's not '00:00:00'
                    if ($endTime && $endTime !== '00:00:00') {
                        $endDateTime .= ' ' . $endTime;
                    }
                        // Log the concatenated date-time strings for debugging
                    Log::info("Start DateTime: " . $startDateTime);
                    Log::info("End DateTime: " . $endDateTime);
                  
                    $start = Carbon::parse($startDateTime);
                    $end = Carbon::parse($endDateTime);
                     // Log to check the combined strings before parsing
      
                    // Calculate total hours
                    $jobHours = $start->diffInMinutes($end) / 60;
                    $totalHours += $jobHours;
                    // Ensure hourly pay is numeric
                    $hourlyPay = floatval($job->hourly_pay);
                    // Calculate total amount
                    $totalAmount += $jobHours * $hourlyPay;
                    $job->update(['status' => JobStatus::COMPLETED->value]);
                }
                 $jobCount = $jobs->count();
                // Create a single invoice for the driver
                Invoice::create([
                    'driver_id' => $driverId,
                    'total_hours' =>  round($totalHours, 2),
                    'total_amount' => round($totalAmount, 2),
                    'total_job' => $jobCount,
                    'is_approved' => false,
                    'approved_by' => null,
                ]);

                //$this->info("Invoice created for driver ID {$driverId} with {$jobCount} jobs and {$totalHours} hours.");
            } catch (\Exception $e) {
                Log::error("Error processing job ID {$job->id}: " . $e->getMessage());
            }
        }

        $this->info('Weekly invoices generated successfully.');
    }
}

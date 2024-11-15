<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tenant;
use App\RolesEnum;
use App\UserStatus;
use Illuminate\Validation\Rules;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use Carbon\Carbon;
use App\JobStatus;
use App\Models\Invoice;
use Log;
use Hash;

class InvoiceController extends Controller
{
    
  /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user() || !Auth::user()->hasRole(RolesEnum::SITEMANAGER->value)) {
            abort(code: 403);
        }  
          $invoices = Invoice::with('job')->get();     
        return view('site.invoice.index', compact('invoices'));

        // $currentDate = Carbon::now()->toDateString();
        // $currentTime = Carbon::now()->toTimeString();    
        // $completedJobs = Job::where('status', '!=', JobStatus::COMPLETED->value)->whereHas('driversBids', function ($query) {
        //         $query->where('assigned', 1);
        //     })
        //     ->whereDate('end_date', '<', $currentDate)
        //     ->orWhere(function($query) use ($currentDate, $currentTime) {
        //         $query->whereDate('end_date', '=', $currentDate)
        //             ->whereTime('end_time', '<=', $currentTime);
        //     }) // Assuming status column for tracking job completion
        //     ->get();
        //     foreach ($completedJobs as $job) {
        //         try {
        //             // Retrieve the driver_id from the first assigned bid, if available
        //             $assignedBid = $job->driversBids->firstWhere('assigned', 1);
        //             $driverId = $assignedBid ? $assignedBid->driver_id : null;
            
        //             // Update job status to completed
        //             $job->update(['status' => JobStatus::COMPLETED]);
            
        //             // Calculate total hours and amount
        //             $start = Carbon::parse($job->start_time);
        //             $end = Carbon::parse($job->end_time);
        //             $totalHours = $end->diffInHours($start);
        //             $totalAmount = $totalHours * $job->hourly_pay;
            
        //             // Check if driver_id is set
        //             if ($driverId) {
        //                 // Create invoice entry
        //                 Invoice::create([
        //                     'job_id' => $job->id,
        //                     'driver_id' => $driverId,
        //                     'total_hours' => $totalHours,
        //                     'total_amount' => $totalAmount,
        //                     'is_approved' => false,
        //                     'approved_by' => null,
        //                 ]);
        //             } else {
        //                 Log::warning("Job ID {$job->id} has no driver assigned, skipping invoice creation.");
        //             }
        //         } catch (Exception $e) {
        //             Log::error("Failed to process job ID {$job->id}: " . $e->getMessage());
        //         }
        //     }
            
      
    }
    public function toggleApproval(Request $request)
    {
        $invoice = Invoice::findOrFail($request->invoice_id);
        // Toggle the is_approved status
        $invoice->is_approved = !$invoice->is_approved;
        $invoice->approved_by = $invoice->is_approved ? auth()->id() : null; // Set approved_by or remove it if unapproved
        $invoice->save();
    
        return response()->json([
            'success' => true,
            'is_approved' => $invoice->is_approved,
            'message' => $invoice->is_approved ? 'Invoice approved successfully.' : 'Invoice unapproved successfully.',
        ]);
    }
    
}

<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Jobs\AssignedJob;
use App\Models\Job;
use App\Models\User;
use App\Models\JobBid;
use App\Models\JobTitle;
use App\Models\Department;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Make sure to include this line
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\RolesEnum;
use App\JobStatus;
use App\Models\UserNotification;
use App\NotificationStatus;


class JobController extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value,RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        $jobs = Job::where('tenant_id', tenant('id'))->with(['departments', 'location','job_department_title'])->orderBy('id', 'desc')  // Order by latest
        ->get();
        return view('site.job.index', compact('jobs'));
    }

    public function create()
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value,RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        $departments = Department::all();
        $locations = Location::where('tenant_id', tenant('id'))->get();
        return view('site.job.create', compact('departments', 'locations'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value,RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        $request->validate([
            'department_ids' => 'required', // updated for array validation
            'location_id' => 'required',
            'title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'hourly_pay' => 'required|numeric',
            'start_time' => 'required|date_format:H:i', // Validate time format
            'end_time' => 'required|date_format:H:i',   // Validate time format
        ]);
       // DB::beginTransaction();
        try {
            // First, create the Job record
            $job = Job::create([
                'location_id' => $request->location_id,
                'title' => $request->title,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'hourly_pay' => $request->hourly_pay,
                'start_time' => $request->start_time, // Validate time format
                'end_time' => $request->end_time,   // Validate time format
                'description' => $request->description
            ]);
            // Check if Job creation was successful
            if (!$job) {
                throw new \Exception("Job creation failed.");
            }
           
            // Log to confirm Job ID
            Log::info('Job created with ID: ' . $job->id);
          
            // Then, attach departments to the job
            $job->departments()->attach($request->department_ids);
    
    //        DB::commit();
    
            return redirect()->route('jobs.index')->with('success', 'Job created successfully.');
        } catch (\Exception $e) {
            //DB::rollback();
            Log::error('Error creating job and attaching departments: ' . $e->getMessage());
            return redirect()->back()->with('error' ,'Job not created successfully');
        }
    }

    public function show(Job $job)
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value,RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        // Check if the driver has already placed a bid on this job
      //  $hasBid = $job->driversBids()->where('driver_id', $driver->id)->exists();
        $driverBidders = $job->bidders; // This will fetch the drivers through the bidders relationship
        // $job = Job::find(3); // Replace $jobId with the actual job ID
        // $biddersQuery = $job->bidders(); // Get the query builder instance
        
        // // Print the SQL query and bindings
        // dd($biddersQuery->toSql(), $biddersQuery->getBindings());
        return view('site.job.show', compact('job', 'driverBidders'));
      
    }
    public function showAavailableJob(Job $job)
    {
        if (!Auth::user()->hasRole(RolesEnum::SITEDRIVER->value)) {
            abort(code: 403);
        }
        $driver = auth()->user();
            // Check if the job has been assigned
        $assignedBid = $job->driversBids()->where('assigned', 1)->first();
        // Check if the authenticated driver is the one assigned to this job
        $isAssignedToMe = $assignedBid && $assignedBid->driver_id === $driver->id;
            // Check if the driver has already placed a bid on this job
        $hasBid = $job->driversBids()->exists();

        return view('site.job.show_driver_single_job', compact('job', 'assignedBid', 'isAssignedToMe','hasBid'));
      
    }
    public function edit(Job $job)
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value,RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        $departments = Department::all();
        $locations = Location::all();
        return view('site.job.edit', compact('job', 'departments', 'locations'));
    }

    public function update(Request $request, Job $job)
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value,RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        $request->validate([
            'department_ids' => 'required|array', // Ensure it's an array
            'department_ids.*' => 'exists:departments,id', // Validate each ID exists in departments
            'location_id' => 'required|exists:locations,id', // Ensure the location exists
            'title' => 'required|string|max:255', // Optional: add max length
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'hourly_pay' => 'required|numeric|min:0', // Optional: ensure it's not negative
            
        ]);
        $data = $request->all();
        $request->except('department_ids');
        // Only set the time fields if they are provided, otherwise retain existing values
        $data['start_time'] = $request->start_time ?: $job->start_time;
        $data['end_time'] = $request->end_time ?: $job->end_time;
        $data['status'] = JobStatus::INPROGRESS->value;

        // Update the job details
        $job->update($data); // Exclude department_ids from the update
    
        // Sync departments to ensure existing associations are updated
        $job->departments()->sync($request->department_ids);
    
        return redirect()->route('jobs.index')->with('success', 'Job updated successfully.');
    }

    public function destroy(Job $job)
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value,RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        $job->delete();
        return redirect()->route('jobs.index')->with('success', 'Job deleted successfully.');
    }

     // Show available jobs for a driver
     public function availableJobs()
     {
        if (!Auth::user()->hasRole(RolesEnum::SITEDRIVER->value)) {
            abort(code: 403);
        }
    
         $driver = auth()->user(); // Assuming the driver is authenticated
         $driverDepartmentIds = $driver->departments->pluck('id'); // Get department IDs for the driver
          // Fetch available jobs: Jobs in the driver's departments that they haven't won
        //   $availableJobs = Job::whereIn('id', function ($query) use ($driverDepartmentIds) {
        //     $query->select('job_id')
        //           ->from('department_job') // Reference to department_job table
        //           ->whereIn('department_id', $driverDepartmentIds); // Filter by driver's departments
        // })
        // ->whereDoesntHave('drivers', function ($query) use ($driver) {
        //     $query->where('driver_id', $driver->id); // Exclude jobs already assigned to the driver
        // })
        // ->get();
        $availableJobs = Job::with('job_department_title')->where('tenant_id',tenant('id'))->whereIn('id', function ($query) use ($driverDepartmentIds) {
            $query->select('job_id')
                  ->from('department_job')
                  ->whereIn('department_id', $driverDepartmentIds); // Filter by department IDs
        }) // Exclude jobs that have bids
        ->orderBy('created_at', 'desc')  // Order by latest
        ->get();
         return view('site.job.available', compact('availableJobs'));
     }
 
     // Show jobs the driver has won
     public function wonJobs()
     {
         $driver = auth()->user(); // Assuming the driver is authenticated
         $driverDepartmentIds = $driver->departments->pluck('id'); // Get department IDs for the driver
         $wonJobs = Job::with('job_department_title')->whereIn('id', function ($query) use ($driverDepartmentIds) {
            $query->select('job_id')
                  ->from('department_job')
                  ->whereIn('department_id', $driverDepartmentIds); // Filter by department IDs
        })->whereHas('bids', function ($query) use ($driver) {
            $query->where('driver_id', $driver->id)
                  ->where('assigned', 1); // Only include assigned bids
        })
        ->orderBy('created_at', 'desc')  // Order by latest
        ->get();
         return view('site.job.won', compact('wonJobs'));
     }
 
     // Bid for a job
     public function bid(Request $request, Job $job)
     {
        $driver = auth()->user();

        // Check if the driver has already placed a bid or won this job
        if ($job->drivers()->where('driver_id', $driver->id)->exists()) {
            return redirect()->route('jobs.available')->with('error', 'You have already bid or been assigned to this job.');
        }
    
        // Associate the driver with the job in the job_bid table
        $job->drivers()->attach($driver->id);
    
        return redirect()->route('jobs.available')->with('success', 'Job bid successfully!');
     }
     public function submitBid(Request $request, Job $job)
        {
            $driver = auth()->user();

            // Check if the driver has already bid on this job
            if ($job->driversBids()->where('driver_id', $driver->id)->exists()) {
                return redirect()->route('jobs.showAavailableJob', $job)->with('error', 'You have already bid for this job.');
            }
            // Create a new bid for this job by the driver
            $jobBid = new JobBid();
            $jobBid->job_id = $job->id; // Assign job id
            $jobBid->driver_id = $driver->id; // Assign driver id
            $jobBid->save(); // Save the bid

            return redirect()->route('jobs.showAavailableJob', $job)->with('success', 'Bid submitted successfully!');
        }
        public function assignJob(Request $request, Job $job, $driverId)
        {
            $driver = User::findOrFail($driverId);
            // Check if the job already has an assigned driver
            $currentJobBid = JobBid::where('job_id', $job->id)->where('assigned', 1)->first();
            // If a driver is currently assigned, unassign them
            if ($currentJobBid) {
                $currentJobBid->assigned = 0; // Mark the current driver as unassigned
                $currentJobBid->save();
            }
            // Now assign the job to the new driver
            $jobBid = JobBid::where('job_id', $job->id)->where('driver_id', $driver->id)->first();
            
            if ($jobBid) {
                $jobBid->assigned = 1; // Mark the new driver as assigned
                $jobBid->bid_date = now();
                $jobBid->save();
                $hasNotification = UserNotification::where('user_id', $driver->id)
                                ->where('notification_type', 'job_won')
                                ->where('status',NotificationStatus::ACTIVE->value )
                                ->exists();
            if($hasNotification){
                AssignedJob::dispatch($job, $driver);
            }
                return redirect()->route('jobs.index')->with('success', 'Job assigned successfully!');
            }

            return redirect()->route('jobs', $job->id)->with('error', 'Failed to assign job.');
        }
        public function getJobTitles($id)
        {
            // Fetch job titles where department_id matches the selected department
            $jobTitles = JobTitle::where('department_id', $id)->pluck('job_title', 'id');
            // Return job titles as a JSON response
            return response()->json($jobTitles);
        }
 
}


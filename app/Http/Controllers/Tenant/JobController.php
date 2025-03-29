<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Jobs\AssignedJob;
use App\Models\Job;
use App\Models\Notification;
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
use App\Services\NotificationService;


class JobController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    public function index()
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value, RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        $jobs = Job::where('tenant_id', tenant('id'))->with(['departments', 'location', 'job_department_title'])->orderBy('id', 'desc')  // Order by latest
            ->paginate(perPage: 10);
        return view('site.job.index', compact('jobs'));
    }

    public function create()
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value, RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        $departments = Department::all();
        $locations = Location::where('tenant_id', tenant('id'))->get();
        return view('site.job.create', compact('departments', 'locations'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value, RolesEnum::SITEUSER->value])) {
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
        $bookingRef = 'JOB-' . strtoupper(uniqid());
        DB::beginTransaction();
        try {
            // First, create the Job record
            $job = Job::create([
                'booking_ref' => $bookingRef,
                'passenger_name' => $request->passenger_name,
                'passenger_contact_number' => $request->passenger_contact_number,
                'location_id' => $request->location_id,
                'title' => $request->title,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'hourly_pay' => $request->hourly_pay,
                'start_time' => $request->start_time, // Validate time format
                'end_time' => $request->end_time,   // Validate time format
                'description' => $request->description,
                'round_trip' => $request->round_trip == 'on' ? 1 : 0
            ]);
            
            $addresses = $request->addresses;

            if ($addresses) {
                foreach ($addresses as $address) {
                    $job->addresses()->create([
                        'address' => $address,
                    ]);
                }
            }
            // Then, attach departments to the job
            $job->departments()->attach($request->department_ids);

            // Fetch all drivers in the selected departments
            $drivers = User::whereHas('departments', function ($query) use ($request) {
                $query->whereIn('department_id', $request->department_ids);
            })->get();
            // Send notification to all drivers
            foreach ($drivers as $driver) {
                $this->notificationService->create($driver->id, "New job posted");
            }

              DB::commit();

            return redirect()->route('jobs.index')->with('success', 'Job created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating job and attaching departments: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Job not created successfully');
        }
    }

    public function show(Job $job)
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value, RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        // Check if the driver has already placed a bid on this job
        //  $hasBid = $job->driversBids()->where('driver_id', $driver->id)->exists();
        $driverBidders = $job->bidders; // This will fetch the drivers through the bidders relationship
        // $job = Job::find(3); // Replace $jobId with the actual job ID
        // $biddersQuery = $job->bidders(); // Get the query builder instance

        // // Print the SQL query and bindings
        // dd($biddersQuery->toSql(), $biddersQuery->getBindings());
        // get adddress against this job
        $addresses = $job->addresses()->pluck('address')->toArray();


        return view('site.job.show', compact('job', 'driverBidders', 'addresses'));

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
        $getDriverBidPrice = $job->driversBids()->where('driver_id', Auth::user()->id)->first();

        return view('site.job.show_driver_single_job', compact('job', 'assignedBid', 'isAssignedToMe', 'hasBid', 'getDriverBidPrice'));

    }
    public function edit(Job $job)
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value, RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        $departments = Department::all();
        $locations = Location::all();
        // Fetch the addressess associated with the job
        $addresses = $job->addresses()->pluck('address')->toArray();

        return view('site.job.edit', compact('job', 'departments', 'locations', 'addresses'));
    }

    public function update(Request $request, Job $job)
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value, RolesEnum::SITEUSER->value])) {
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
        $data['round_trip'] = $request->round_trip == 'on' ? 1 : 0;

        // Update the job details
        $job->update($data); // Exclude department_ids from the update

        // Sync departments to ensure existing associations are updated
        $job->departments()->sync($request->department_ids);

        // Update addresses if provided
        $addresses = $request->addresses;
        if ($addresses) {
            // Clear existing addresses
            $job->addresses()->delete();
            // Add new addresses
            foreach ($addresses as $address) {
                $job->addresses()->create([
                    'address' => $address,
                ]);
            }
        } else {
            // If no addresses are provided, clear existing ones
            $job->addresses()->delete();
        }

        return redirect()->route('jobs.index')->with('success', 'Job updated successfully.');
    }

    public function destroy(Job $job)
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value, RolesEnum::SITEUSER->value])) {
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
        $availableJobs = Job::with('job_department_title')->where('tenant_id', tenant('id'))->whereIn('id', function ($query) use ($driverDepartmentIds) {
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
        $checkBidOffer = $request->bid_offer;
        $jobBid = JobBid::where('job_id', $job->id)->where('driver_id', $driver->id)->first();

        if ($checkBidOffer == 1) {
            $note = "Driver has accepted the your offer";
            $assigned = 0;
        } else {
            if ($jobBid && $jobBid->assigned == 3) {
                $assigned = 4;
                $note = "Driver has sent a second offer";

            } else {
                $assigned = 2;
                $note = "Driver has placed a bid";
            }
        }
        // Get site manger id who created the job
        $siteManagerId = $job->location->user_id;
        $this->notificationService->create($siteManagerId, "Driver has placed a bid for the job");
        // Assigned 2 means rebid offer this job
        if ($job->driversBids()->where('driver_id', $driver->id)->whereNotIn('assigned', array(2, 3))->exists()) {
            return redirect()->route('jobs.showAavailableJob', $job)->with('error', 'You have already bid for this job.');
        }
        // If job id and driver id allready exist then update the bid price not create job bid record
        if ($jobBid) {
            $jobBid->bid_price = $request->bid_price;
            $jobBid->assigned = $assigned;   /// 2 mean user bid price 
            $jobBid->note = $note;
            $jobBid->save();
        } else {
            $jobBid = new JobBid();
            $jobBid->job_id = $job->id;
            $jobBid->driver_id = $driver->id;
            $jobBid->bid_price = $request->bid_price;
            $jobBid->assigned = $assigned;
            $jobBid->note = $note;
            $jobBid->save();
        }

        return redirect()->route('jobs.showAavailableJob', $job)->with('success', 'Bid submitted successfully!');
    }
    public function assignJob(Request $request, Job $job, $driverId)
    {
        $action = $request->action;
        $bid_price = $request->bid_price;

        if ($action === 'counter_offer') {
            $note = "Admin has sent a counter offer";
            // Assigned 2 means rebid offer this job
            $jobBid = JobBid::where('job_id', $job->id)->where('driver_id', $driverId)->first();
            $jobBid->assigned = 3; // 3 means Admin send counter offer this job to driver
            $jobBid->note = $note;
            $jobBid->bid_price = $bid_price;
            $jobBid->save();
            $this->notificationService->create($driverId, "Admin send the Counter Offer to dirver!");
            return redirect()->route('jobs.index')->with('success', 'Admin send the Counter Offer to dirver!');
        }
        if ($action === 'reject') {
            $note = "Admin has rejected your offer. Please reapply if you wish to proceed";
            $jobBid = JobBid::where('job_id', $job->id)->where('driver_id', $driverId)->first();
            $jobBid->assigned = 5; // 5 means Admin send reject this job to driver
            $jobBid->note = $note;
            $jobBid->save();
            $this->notificationService->create($driverId, "Admin has rejected your offer. Please reapply if you wish to proceed!");
            return redirect()->route('jobs.index')->with('success', 'Admin has rejected your offer. Please reapply if you wish to proceed!');
        }
        $driver = User::findOrFail($driverId);
        $jobBid = JobBid::where('job_id', $job->id)->where('driver_id', $driver->id)->first();

        if ($jobBid) {
            $jobBid->assigned = 1; // Mark the new driver as assigned
            $jobBid->bid_date = now();
            $jobBid->save();
            // Update Price also on job table
            $data['hourly_pay'] = $bid_price;
            $job->update($data);
            $hasNotification = UserNotification::where('user_id', $driver->id)
                ->where('notification_type', 'job_won')
                ->where('status', NotificationStatus::ACTIVE->value)
                ->exists();
            if ($hasNotification) {
                AssignedJob::dispatch($job, $driver);
            }
            $this->notificationService->create($driver->id, "You have been assigned to a new job");
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


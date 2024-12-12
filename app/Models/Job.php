<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Job extends Model
{
    use HasFactory;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'driver_job';
    protected $fillable = [
         'location_id', 'title', 'start_date', 'end_date', 'start_time', 'end_time', 'description','tenant_id','user_id', 'hourly_pay', 'status'
    ];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    public function departments()
    {
        //return $this->belongsToMany(Department::class, 'department_job', 'job_id', 'department_id');
        return $this->belongsToMany(Department::class, 'department_job', 'job_id', 'department_id');

    }
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function job_department_title()
    {
        //return $this->belongsToMany(Department::class, 'department_job', 'job_id', 'department_id');
        return $this->belongsTo(JobTitle::class, 'title', 'id');

    }
    public function drivers()
    {
        return $this->belongsToMany(User::class, 'driver_department', 'job_id', 'driver_id');
    }
    public function driversBids()
    {
        return $this->hasMany(JobBid::class); // Assuming JobBid is the name of the model

    }
    public function bidders()
    {
        return $this->belongsToMany(User::class, 'job_bid', 'job_id', 'driver_id');
    }
    public function bids()
    {
        return $this->hasMany(JobBid::class, 'job_id'); // Replace 'job_id' if it uses a different foreign key
    }
     // Automatically set tenant_id and user_id when creating a location
     protected static function booted()
     {
         static::creating(function ($location) {
             $location->tenant_id = tenant('id'); // Assign tenant ID
             $location->user_id = auth()->id();  // Assign logged-in user ID
         });
     }
    // public function drivers()
    // {
    //     return $this->belongsToMany(User::class, 'driver_assign_job');
    // }

}

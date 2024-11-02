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
         'location_id', 'title', 'start_date', 'end_date', 'start_time', 'end_time', 'description', 'hourly_pay'
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
    // public function drivers()
    // {
    //     return $this->belongsToMany(User::class, 'driver_assign_job');
    // }

}

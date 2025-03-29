<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Spatie\Permission\Traits\HasRoles;
use App\UserStatus;

class User extends Authenticatable
{
    use HasFactory, Notifiable, BelongsToTenant, HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'driver_number',
        'note',
        'rating',
        'address',
        'tenant_id',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatus::class, // This is fine for your UserStatus enum
        ];
    }
    protected $casts = [
        'status' => UserStatus::class,
    ];

    public function isActive()
    {
        return $this->status === UserStatus::ACTIVE;
    }
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
    }
    public function departments()
    {
        return $this->belongsToMany(Department::class, 'driver_department');
    }
    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'driver_assign_job');
    }
    public function driverJobs()
    {
        return $this->belongsToMany(Job::class, 'job_bid')
                    ->withTimestamps();
    }public function jobsBids()
    {
        return $this->belongsToMany(Job::class, 'job_bid', 'driver_id', 'job_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['name'];

    // Many-to-many relationship with drivers
    public function drivers()
    {
       // return $this->belongsToMany(User::class, 'driver_department');
       return $this->belongsToMany(User::class, 'driver_department', 'department_id', 'driver_id');

    }
    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'driver_department');
    }
}

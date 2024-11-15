<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class JobTitle extends Model
{
    use HasFactory;
    protected $table = 'department_job_title'; // Ensure this matches your actual table name

}

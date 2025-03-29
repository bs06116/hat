<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Address extends Model
{

    protected $fillable = ['job_id', 'address'];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}

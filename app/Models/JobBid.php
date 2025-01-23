<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobBid extends Model
{
    use HasFactory;

    protected $table = 'job_bid'; // Ensure this matches your actual table name

    protected $casts = [
        'bid_date' => 'datetime'
    ];
    // Define relationships
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class); // Assuming you have a Driver model
    }
}
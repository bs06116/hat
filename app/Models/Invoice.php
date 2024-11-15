<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoices'; // Ensure this matches your actual table name
    protected $fillable = [
        'job_id', 'driver_id', 'total_hours', 'total_amount', 'is_approved', 'approved_by'
   ];
   public function job()
   {
       return $this->belongsTo(Job::class); 
   }
   public function user()
    {
        return $this->hasOne(User::class, 'id', 'driver_id');
    }


}

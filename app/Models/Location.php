<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['name', 'address', 'tenant_id', 'user_id'];
    use HasFactory;
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
     // Automatically set tenant_id and user_id when creating a location
     protected static function booted()
     {
         static::creating(function ($location) {
             $location->tenant_id = tenant('id'); // Assign tenant ID
             $location->user_id = auth()->id();  // Assign logged-in user ID
         });
     }
    
}

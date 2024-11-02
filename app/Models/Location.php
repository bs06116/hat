<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['name','address'];
    use HasFactory;
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
    
}

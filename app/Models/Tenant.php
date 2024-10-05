<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    public static function getCustomColumns() :array
    {
         return [
            'id',
            'name',
            'email',
            'password',
         ];
    }
    public function setPasswordAtribute($value){
        return $this->attributes['password'] = bcrypt($value);
    }
     // Other model code...

  
    // Define the relationship to the users
    public function user()
    {
        return $this->hasOne(User::class, 'tenant_id', 'id'); // tenant_id in users table references id in tenants table
    }

    // Define the relationship to the domains
    public function domain()
    {
        return $this->hasOne(Domain::class, 'tenant_id', 'id');
    }
    
}
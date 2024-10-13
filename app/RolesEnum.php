<?php

namespace App;

enum RolesEnum: string
{
    // case NAMEINAPP = 'name-in-database';

    case SUPERADMIN = 'super-admin';
    case SITEMANAGER = 'site-manager';
    case SITEUSER = 'site-user';
    case SITEDRIVER = 'site-driver';

    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            static::SUPERADMIN => 'Super Admin',
            static::SITEMANAGER => 'Site Manager',
            static::SITEUSER => 'Site Admin',
            static::SITEDRIVER => 'Driver'
        };
    }
}
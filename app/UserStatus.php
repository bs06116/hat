<?php

namespace App;

enum UserStatus: string
{
    case ACTIVE = 'active';
    case DEACTIVE = 'deactive';

    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            static::ACTIVE => 'Active',
            static::DEACTIVE => 'Deactive',
        };
    }
}
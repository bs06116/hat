<?php

namespace App;

enum JobStatus: string
{
    case COMPLETED = 'completed';
    case INPROGRESS = 'inprogress';

    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            static::COMPLETED => 'Completed',
            static::INPROGRESS => 'InProgress',
        };
    }
}
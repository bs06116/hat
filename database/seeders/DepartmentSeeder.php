<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\RolesEnum;
use App\Models\Role;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $input = [
            'Events',
            'Home to School',
            'PTS'
        ];

        foreach ($input as $value) {
            Department::create([
                'name' => $value,
            ]);
        }
    }
}

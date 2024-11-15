<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\JobTitle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\RolesEnum;
use App\Models\Role;

class DepartmentJobTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          // Department data with job titles
          $departments = [
            'PTS' => [
                'ACA',
                'ACA FREC 3',
                'ACA FREC 4'
            ],
            'Home to School' => [
                'PSV (D or D1 Driver)',
                'PCO owner driver 4 seat',
                'PCO owner driver 8 seat',
                'PCO owner driver wheelchair',
                'Passenger Assistant',
                'PCO HATS company vehicle',
            ],
            'Events' => [
                'ACA',
                'FREC 3',
                'FREC 4',
                'ECA',
                'Paramedic',
            ],
        ];

        // Loop through each department and create records
        foreach ($departments as $departmentName => $jobTitles) {
            // Create department
            $department = Department::create(['name' => $departmentName]);

            // Create job titles associated with the department
            foreach ($jobTitles as $title) {
                JobTitle::create([
                    'department_id' => $department->id,
                    'job_title' => $title,
                ]);
            }
        }
    }
}

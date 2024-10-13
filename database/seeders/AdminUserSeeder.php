<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\RolesEnum;
class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $input = [
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@hats.com',
            'password' => Hash::make('12345678'),
            'phone' => '7878454512',
            'email_verified_at' => Carbon::now(),
        ];

        $user = User::create($input);
        $user->assignRole(RolesEnum::SUPERADMIN);
    }
}

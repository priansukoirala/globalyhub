<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                "first_name" => "Super",
                "last_name" => "Admin",
                "username" => "super-admin",
                "gender" => "female",
                "address" => "KTM",
                "nationality" => "Muslim",
                "dob" => "1997-07-07",
                "education" => "BCIS",
                "contact_number" => "9843232440",
                "email" => "superadmin@gmail.com",
                "password" => Hash::make('super-admin'),
            ]
        ];

        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}

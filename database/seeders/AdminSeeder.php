<?php

namespace Database\Seeders;

use App\Models\SystemUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = SystemUser::where('email','admin@gmail.com')->first();
        if(!$admin){
            SystemUser::create([
                'firstname' => 'JUMA',
                'middlename' => 'HAJI',
                'lastname' => 'JUMA',
                'email' => 'admin@gmail.com',
                'phone' => '07738383',
                'role' => 'admin',
                'password' => Hash::make('12345678')

            ]  
            );
        }
    }
}

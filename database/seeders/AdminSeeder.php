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
        $admin = SystemUser::where('email','hamad.said@ipa.ac.tz')->first();
        if(!$admin){
            SystemUser::create([
                'firstname' => 'HAMAD',
                'middlename' => 'KHAMIS',
                'lastname' => 'SAID',
                'email' => 'hamad.said@ipa.ac.tz',
                'phone' => '0777430694',
                'role' => 'admin',
                'password' => Hash::make('12345678')

            ]  
            );
        }
    }
}

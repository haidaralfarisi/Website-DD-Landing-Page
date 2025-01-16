<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'superadmin',
                'email' => 'superadmin@diandidaktika.sch.id',
                'nip' => '12345',
                'email_verified_at' => now(),
                'password' => bcrypt('superadmin123'),
                'level' => 'superadmin',
                'unit_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'admin',
                'email' => 'admin@diandidaktika.sch.id',
                'nip' => '123456',
                'email_verified_at' => now(),
                'password' => bcrypt('admin123'),
                'level' => 'admin',
                'unit_id' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert data ke dalam tabel users
        User::insert($users);
    }
}

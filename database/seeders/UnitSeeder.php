<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('units')->insert([
            ['name' => 'Unit A', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Unit B', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Unit C', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

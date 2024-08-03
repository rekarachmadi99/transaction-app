<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->insert([
            [
                'employee_id' => 1,
                'first_name' => 'Reka',
                'last_name' => 'Rachmadi Apriansyah',
                'email' => 'reka.rachmadi@example.com',
                'phone' => '082311129049',
                'address' => 'Tasikmalaya',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}

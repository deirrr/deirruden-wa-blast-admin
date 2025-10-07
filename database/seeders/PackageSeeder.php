<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Package::firstOrCreate(['name' => 'Free'], ['duration_days' => 30, 'price' => 0]);
        \App\Models\Package::firstOrCreate(['name' => 'Basic'],  ['duration_days' => 30, 'price' => 15000]);
        \App\Models\Package::firstOrCreate(['name' => 'Max'],  ['duration_days' => 30, 'price' => 30000]);
    }
}

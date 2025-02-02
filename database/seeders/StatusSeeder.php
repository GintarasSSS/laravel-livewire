<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::firstOrCreate(['name' => 'pending']);
        Status::firstOrCreate(['name' => 'approved']);
        Status::firstOrCreate(['name' => 'rejected']);
    }
}

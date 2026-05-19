<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Sample Projects
        DB::table('projects')->insert([
            ['name' => 'EPC Project A - Warehouse Site', 'code' => 'PROJ-A'],
            ['name' => 'EPC Project B - Industrial Structure', 'code' => 'PROJ-B'],
            ['name' => 'Interior Project X - Executive Office Suite', 'code' => 'PROJ-X'],
        ]);

        // 2. Seed Master Cost Codes
        DB::table('cost_codes')->insert([
            ['code' => 'CC-001', 'activity_name' => 'Excavation & Earthwork'],
            ['code' => 'CC-042', 'activity_name' => 'RCC Footing Concrete Laying'],
            ['code' => 'CC-109', 'activity_name' => 'Brickwork Masonry - 9 inch Wall'],
            ['code' => 'CC-512', 'activity_name' => 'Gypsum False Ceiling Framing'],
        ]);
    }
}
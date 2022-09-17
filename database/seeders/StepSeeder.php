<?php

namespace Database\Seeders;

use App\Enums\StepStatus;
use App\Models\Step;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Step::create(['status' => StepStatus::Step1->value]);
    }
}

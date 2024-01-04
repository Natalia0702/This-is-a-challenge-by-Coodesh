<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Expense;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Expense::factory(10)->create();
    }
}

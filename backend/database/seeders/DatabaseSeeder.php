<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin 1',
                'email' => 'admin@mail.com',
                'password' => Hash::make('power@123'),
            ],
            [
                'name' => 'usuario1',
                'email' => 'usuario1@gmail.com',
                'password' => Hash::make('123'),
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate([
                'email' => $user['email'],
            ], $user);
        }

        User::factory(10)->create();

        $this->call([
            ExpenseSeeder::class,
        ]);
    }
}

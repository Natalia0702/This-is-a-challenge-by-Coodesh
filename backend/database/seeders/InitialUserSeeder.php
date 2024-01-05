<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class InitialUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
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

        $adminRole = Role::updateOrCreate(
            [
                'name' => 'Admin'
            ],
            ['name' => 'Admin']
        );

        foreach ($users as $userData) {
            $user = User::updateOrCreate([
                'email' => $userData['email'],
            ], $userData);

            $user->roles()->sync($adminRole);
        }

        User::factory(10)->create();
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Vincent',
            'email' => 'vincent@mail.com'
        ]);

        User::factory()->create([
            'name' => 'Maurice',
            'email' => 'maurice@mail.com'
        ]);

        User::factory()->create([
            'name' => 'Rajahwu',
            'email' => 'rajahwu@mail.com',
            'role' => 'instructor'
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'role' => 'admin'
        ]);

        User::factory()->count(10)->create();

        User::factory()->count(10)->create([
            'role' => 'instructor',
        ]);
    }
}

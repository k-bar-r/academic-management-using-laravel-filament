<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Standard;
use App\Models\Guardian;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'kbarr',
            'email' => 'kbar@ackda.com',
            'password' => bcrypt('123344'),
        ]);

        // Student::factory(10)
        // ->has(Guardian::factory()->count(3))
        // ->create();

        // $this->call(StandardSeeder::class);
    }
}

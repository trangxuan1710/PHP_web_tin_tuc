<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
//    public function run()
//    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
<<<<<<< HEAD
//    }
    public function run()
    {
        $this->call(NewsSeeder::class);
=======
        $this->call([
            CommentTestSeeder::class,
        ]);
        $this->call(NewsSeeder::class);

>>>>>>> 42725f4615a5c4efc65cdf65e1404bddf2978bf3
    }
}

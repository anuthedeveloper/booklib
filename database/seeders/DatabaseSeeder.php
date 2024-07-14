<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// use App\Models\User;
use App\Models\Author;
use App\Models\Book;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    
    // public function run(): void
    // {
    // //    User::factory(10)->create();

    // User::factory()->create([
    //     'name' => 'Test User',
    //     'email' => 'test@example.com',
    // ]);
    // }

    public function run()
    {
        // Generate 10 authors, each with 5 books
        Author::factory()
            ->count(10)
            ->hasBooks(5) // Assuming you have defined this relationship in your Author model
            ->create();
    }
}

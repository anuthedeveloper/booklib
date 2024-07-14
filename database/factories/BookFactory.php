<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    
    protected $model = Book::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'author_id' => Author::factory(), // Generates a new Author for each book
            'published_date' => $this->faker->date(),
            'isbn' => $this->faker->unique()->isbn13,
            'summary' => $this->faker->paragraph,
            'cover_image' => $this->faker->imageUrl(400, 600, 'books', true, 'Faker'), // URL to a fake cover image
            'thumbnail' => $this->faker->imageUrl(200, 300, 'books', true, 'Faker'),  // URL to a fake thumbnail image
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

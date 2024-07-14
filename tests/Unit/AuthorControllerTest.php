<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_author()
    {
        $authorData = [
            'name' => 'John Doe',
            'biography' => 'A famous author.',
            'date_of_birth' => '1980-01-01',
        ];

        $response = $this->postJson('/api/authors', $authorData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('authors', ['name' => 'John Doe']);
    }

    /** @test */
    public function it_can_update_an_author()
    {
        $author = Author::factory()->create();

        $response = $this->putJson("/api/authors/{$author->id}", [
            'name' => 'Updated Name',
            'biography' => 'Updated biography.',
            'date_of_birth' => '1985-01-01',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('authors', ['name' => 'Updated Name']);
    }

    /** @test */
    public function it_can_delete_an_author()
    {
        $author = Author::factory()->create();

        $response = $this->deleteJson("/api/authors/{$author->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }
}

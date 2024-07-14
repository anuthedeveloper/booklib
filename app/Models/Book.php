<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author_id', 'published_date', 'isbn', 'summary', 'cover_image', 'thumbnail'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}


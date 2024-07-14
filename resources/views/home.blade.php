@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2>Books</h2>
        </div>
        <!-- <div class="col text-end">
            <a href="{{ route('books.create') }}" class="btn btn-primary">Create New Book</a>
        </div> -->
    </div>

    <div class="row mb-4">
        <div class="col">
            <form action="{{ route('home') }}" method="GET" class="d-flex">
                <input type="text" name="query" class="form-control me-2" placeholder="Search by title or author...">
                <button type="submit" class="btn btn-outline-primary">Search</button>
            </form>
        </div>
    </div>

    <div class="row">
        @forelse($books as $book)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <!-- <img src="{{ $book->thumbnail }}" class="card-img-top" alt="{{ $book->title }}"> -->
                    <div class="card-body">
                        <h5 class="card-title truncate">{{ $book->title }}</h5>
                        <p class="card-text">Author: <a href="{{ route('authors.show', $book->author->id) }}">{{ $book->author->name }}</a></p>
                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col">
                <p>No books found.</p>
            </div>
        @endforelse
    </div>

    @if ($books->total() > 0)
        <div class="row justify-content-center">
            {{ $books->links('vendor.pagination.bootstrap-4') }}
        </div>
    @endif
</div>
@endsection

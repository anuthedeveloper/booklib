@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div><a href="{{ route('authors.index') }}" class="btn btn-secondary btn-sm">Back to Authors</a></div>
            <div class="card mb-4">
                <div class="card-body">
                    <h1 class="card-title">{{ $author->name }}</h1>
                    <p class="card-text">{{ $author->biography }}</p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Books</h5>
                </div>
                <div class="card-body">
                    @if($author->books->isEmpty())
                        <p>No books available for this author.</p>
                    @else
                        <div class="row">
                            @foreach ($author->books as $book)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="card-title text-truncate" style="max-width: 100%;">{{ $book->title }}</h6>
                                            <a href="{{ route('books.show', $book->id) }}" class="btn btn-primary btn-sm">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

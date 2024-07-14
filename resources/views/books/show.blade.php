@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="{{ $book->cover_image }}" class="card-img" alt="{{ $book->title }}">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->title }}</h5>
                            <p class="card-text"><strong>Author:</strong> {{ $book->author->name }}</p>
                            <p class="card-text">{{ $book->summary }}</p>
                            <p class="card-text"><strong>ISBN:</strong> {{ $book->isbn }}</p>
                            <nav>
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary">Edit</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <form id="deleteBookForm" method="POST" action="{{ route('books.destroy', $book->id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this book?')">Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#deleteBookForm').submit(function(event) {
        event.preventDefault();
        const form = $(this);
        // const token = localStorage.getItem('token');
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            headers: {
                'Authorization': 'Bearer ' + '{{ auth()->user()->api_token ?? null }}', 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },
            data: form.serialize(),
            success: function(response) {
                alert(response.message);
                window.location.href = '/books'; // Redirect to books list
            },
            error: function(xhr, status, error) {
                const errorMessage = JSON.parse(xhr.responseText);
                console.error(errorMessage);
                alert(errorMessage.message);
            }
        });
    });
});
</script>
@endsection

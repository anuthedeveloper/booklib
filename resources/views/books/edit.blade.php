@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Book</div>
                <div class="card-body">
                    <div id="successMessage" class="alert alert-success" style="display: none;"></div>
                    <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
                    <form id="updateBookForm" method="POST" action="{{ route('books.update', $book->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" id="title" name="title" class="form-control" value="{{ $book->title }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="summary">Summary:</label>
                            <textarea id="summary" name="summary" class="form-control" rows="5" required>{{ $book->summary }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="author_id">Author:</label>
                            <select id="author_id" name="author_id" class="form-control" required>
                                @foreach ($authors as $author)
                                    <option value="{{ $author->id }}" {{ $book->author_id == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="published_date">Published Date:</label>
                            <input type="date" id="published_date" name="published_date" class="form-control" value="{{ $book->published_date }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="isbn">ISBN:</label>
                            <input type="text" id="isbn" name="isbn" class="form-control" value="{{ $book->isbn }}" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary" id="submitButton">Update Book</button>
                        <a href="{{ route('books.index') }}" class="btn btn-secondary">Back to Books</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#updateBookForm').submit(function(event) {
        event.preventDefault();
        const formData = $(this).serialize(); // Serialize form data
        // const token = localStorage.getItem('token');
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            headers: {
                'Authorization': 'Bearer ' + '{{ auth()->user()->api_token ?? null }}', 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },
            data: formData,
            beforeSend: function() {
                $('#submitButton').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...');
            },
            success: function(response) {
                console.log(response);
                $('#successMessage').text(response.message).show();
                $('#submitButton').prop('disabled', false).html('Update Book');
            },
            error: function(xhr, status, error) {
                const errorMessage = JSON.parse(xhr.responseText);
                console.error(errorMessage);
                $('#errorMessage').text(errorMessage.message).show();
                $('#submitButton').prop('disabled', false).html('Update Book');
            }
        });
    });
});
</script>
@endsection
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3>Add New Book</h3>
                </div>
                <div class="card-body">
                    <div id="successMessage" class="alert alert-success" style="display: none;"></div>
                    <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="addBookForm" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input type="text" id="title" name="title" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="summary">Summary</label>
                            <textarea id="summary" name="summary" class="form-control" rows="5" required></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="author_id">Author</label>
                            <select id="author_id" name="author_id" class="form-control" required>
                                <option value="">-- Select Author</option>
                                @foreach ($authors as $author)
                                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="published_date">Published Date</label>
                            <input type="date" id="published_date" name="published_date" class="form-control" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="isbn">ISBN</label>
                            <input type="text" id="isbn" name="isbn" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="cover_image">Cover Image URL</label>
                            <input type="text" id="cover_image" name="cover_image" class="form-control">
                        </div>

                        <div class="form-group mb-3">
                            <label for="thumbnail">Thumbnail URL</label>
                            <input type="text" id="thumbnail" name="thumbnail" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary w-100" id="submitButton">Add Book</button>
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
    $('#addBookForm').submit(function(event) {
        event.preventDefault();
        const formData = $(this).serialize(); // Serialize form data
        // const token = localStorage.getItem('token');
        $.ajax({
            url: '/api/books',
            type: 'POST',
            headers: {
                'Authorization': 'Bearer ' + '{{ auth()->user()->api_token ?? null }}', 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },
            data: formData,
            beforeSend: function() {
                $('#submitButton').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...');
            },
            success: function(response) {
                console.log(response);
                $('#successMessage').text(response.message).show();
                $('#addBookForm')[0].reset(); // Reset the form
                $('#submitButton').prop('disabled', false).html('Add Book');
            },
            error: function(xhr, status, error) {
                const errorMessage = JSON.parse(xhr.responseText);
                console.error(errorMessage);
                $('#errorMessage').text(errorMessage.message).show();
                $('#submitButton').prop('disabled', false).html('Add Book');
            }
        });
    });
});
</script>
@endsection

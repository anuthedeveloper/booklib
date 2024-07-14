@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2>Edit Author</h2>
                </div>
                <div class="card-body">
                    <div id="successMessage" class="alert alert-success" style="display: none;"></div>
                    <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
                    <form id="editAuthorForm" action="{{ route('authors.update', $author->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $author->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="biography" class="form-label">Biography:</label>
                            <textarea class="form-control" id="biography" name="biography" rows="5" required>{{ $author->biography }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="date_of_birth" class="form-label">Date of Birth:</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ $author->date_of_birth }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary" id="submitButton">Update Author</button>
                        <a href="{{ route('authors.index') }}" class="btn btn-secondary">Back to Authors</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#editAuthorForm').submit(function(event) {
        event.preventDefault(); 
        const formData = $(this).serialize(); // Serialize form data
        // const token = localStorage.getItem('token');
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            headers: {
                'Authorization': 'Bearer ' + '{{ auth()->user()->api_token ?? null }}', 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },
            beforeSend: function() {
                $('#submitButton').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...');
            },
            success: function(response) {
                $('#successMessage').text('Author updated successfully.').show();
                $('#errorMessage').hide();
                $('#submitButton').prop('disabled', false).html('Update Author');
            },
            error: function(xhr, status, error) {
                $('#errorMessage').text('Error updating author: ' + JSON.parse(xhr.responseText).message).show();
                $('#successMessage').hide();
                $('#submitButton').prop('disabled', false).html('Update Author');
            }
        });
    });
});
</script>
@endsection

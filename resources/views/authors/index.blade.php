@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col">
            <h4>Authors</h4>
        </div>
        <div class="col text-end">
            <a href="{{ route('authors.create') }}" class="btn btn-primary">Create New Author</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-6 offset-md-3">
            <form action="{{ route('authors.index') }}" method="GET" class="input-group">
                <input type="text" name="query" class="form-control" placeholder="Search...">
                <button type="submit" class="btn btn-outline-secondary">Search</button>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($authors as $author)
                    <tr id="authorRow{{ $author->id }}">
                        <td>{{ $author->id }}</td>
                        <td>{{ $author->name }}</td>
                        <td>
                            <a href="{{ route('authors.show', $author->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('authors.edit', $author->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteAuthor({{ $author->id }})" id="deleteBtn{{ $author->id }}">Delete</button>
                            <form id="deleteForm{{ $author->id }}" action="{{ route('authors.destroy', $author->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($authors->total() > 0)
        <div class="row justify-content-center">
            {{ $authors->links('vendor.pagination.bootstrap-4') }}
        </div>
    @endif
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function deleteAuthor(authorId) {
    if (confirm('Are you sure you want to delete this author?')) {
        // const token = localStorage.getItem('token');
        $.ajax({
            url: "{{ url('authors') }}" + '/' + authorId,
            type: 'POST',
            headers: {
                'Authorization': 'Bearer {{ auth()->user()->api_token ?? null }}',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                _method: 'DELETE',
            },
            beforeSend: function() {
                $('#deleteBtn' + authorId).prop('disabled', true);
                // $('#loadingSpinner').show();
            },
            success: function(data) {
                $('#authorRow' + authorId).fadeOut();
                $('#successMessage').text('Author deleted successfully.').show();
            },
            error: function(xhr, status, error) {
                console.error(error);
                $('#errorMessage').text('Failed to delete author. Please try again later.').show();
            },
            complete: function() {
                $('#deleteBtn' + authorId).prop('disabled', false);
                // $('#loadingSpinner').hide();
            }
        });
    }
}
</script>
@endsection

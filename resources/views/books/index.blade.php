@extends('layouts.app')

@section('content')
<div class="container">
     <div class="row mb-4">
        <div class="col-6 col-md-6">
            <h1>Books</h1>
        </div>
        <div class="col-6 col-md-6 text-end">
            <a href="{{ route('books.create') }}" class="btn btn-primary">Create New Book</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="row mb-4">
        <div class="col">
            <form action="{{ route('books.index') }}" method="GET" class="d-flex">
                <input type="text" name="query" class="form-control me-2" placeholder="Search...">
                <button type="submit" class="btn btn-outline-primary">Search</button>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Author</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($books as $book)
                    <tr>
                        <td>{{ $book->id }}</td>
                        <td><div class="truncate"> {{ strlen($book->title) > 30 ? substr($book->title, 0, 30) . '...' : $book->title }}</div></td>
                        <td>{{ $book->author->name }}</td>
                        <td>
                            <a href="{{ route('books.show', $book->id) }}" class="btn btn-info btn-sm me-1">View</a>
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary btn-sm me-1">Edit</a>
                            <form  class="d-inline delete-form" action="{{ route('books.destroy', $book->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this book?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No books found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($books->total() > 0)
        <div class="row justify-content-center">
            {{ $books->links('vendor.pagination.bootstrap-4') }}
        </div>
    @endif
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.delete-form').on('submit', function(event) {
        event.preventDefault();
        const form = this;
        if (confirm('Are you sure you want to delete this author?')) {
            // const token = localStorage.getItem('token');
            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + '{{ auth()->user()->api_token ?? null }}',
                },
                data: $(form).serialize(),
                success: function(response) {
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Delete failed:', error);
                    alert('An error occurred while trying to delete the author.');
                }
            });
        }
    });
});
</script>
@endsection
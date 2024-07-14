<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    // API Methods

    public function index()
    {
        $books = Book::with('author')->paginate(10);

        return response()->json($books);
    }

    public function store(Request $request)
    {
        try {
            $this->validateRequest($request);

            $book = Book::create($request->all());

            return response()->json([
                'message' => 'Book created successfully.',
                'data' => $book,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show($id)
    {
        $book = Book::with('author')->findOrFail($id);

        return response()->json($book);
    }

    public function update(Request $request, $id)
    {
        try {
            $book = Book::findOrFail($id);

            $this->validateRequest($request, $book->id);

            $book->update($request->all());

            return response()->json([
                'message' => 'Book updated successfully.',
                'data' => $book,
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json(['message' => 'Book deleted successfully']);
    }

    // Web Views Methods

    public function searchBooks($request)
    {
        $searchQuery = $request->input('query');

        return Book::with('author')
                    ->where('title', 'like', '%'.$searchQuery.'%')
                    ->orWhereHas('author', function ($queryBuilder) use ($searchQuery) {
                        $queryBuilder->where('name', 'like', '%'.$searchQuery.'%');
                    })
                    ->paginate(10);
    }

    public function home(Request $request)
    {
        $books = $this->searchBooks($request);
        return view('home', compact('books'));
    }

    public function indexView(Request $request)
    {
        $books = $this->searchBooks($request);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::all();
        return view('books.create', compact('authors'));
    }

    public function showView($id)
    {
        $book = Book::with('author')->findOrFail($id);
        $authors = Author::all();
        return view('books.show', compact('book', 'authors'));
    }

    public function edit($id)
    {
        $book = Book::with('author')->findOrFail($id);
        $authors = Author::all();
        return view('books.edit', compact('book', 'authors'));
    }

    // Validation Method

    private function validateRequest(Request $request, $bookId = null)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'published_date' => 'required|date',
            'isbn' => 'required|string|unique:books,isbn,' . ($bookId ? $bookId : 'NULL'),
            'summary' => 'required|string',
        ], [
            'title.required' => 'The title is required.',
            'author_id.required' => 'The author ID is required.',
            'author_id.exists' => 'The selected author ID does not exist.',
            'published_date.required' => 'The published date is required.',
            'isbn.required' => 'The ISBN is required.',
            'isbn.unique' => 'The ISBN must be unique.',
            'summary.required' => 'The summary is required.',
        ]);
    }
}

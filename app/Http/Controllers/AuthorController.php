<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthorController extends Controller
{
    // API Methods

    public function index()
    {
        $authors = Author::with('books')->paginate(10);

        return response()->json($authors);
    }

    public function store(Request $request)
    {
        try {
            $this->validateRequest($request);

            $author = Author::create($request->all());

            return response()->json([
                'message' => 'Author created successfully.',
                'data' => $author,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show($id)
    {
        $author = Author::with('books')->findOrFail($id);

        return response()->json($author);
    }

    public function update(Request $request, $id)
    {
        try {
            $author = Author::findOrFail($id);

            $this->validateRequest($request);

            $author->update($request->all());

            return response()->json([
                'message' => 'Author updated successfully.',
                'data' => $author,
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy($id)
    {
        $author = Author::findOrFail($id);
        $author->delete();

        return response()->json(['message' => 'Author deleted successfully']);
    }

    // Web Views Methods

    public function indexView(Request $request)
    {
        $query = $request->input('query');
        $authors = Author::with('books')
                        ->where('name', 'like', '%'.$query.'%')
                        ->orWhere('biography', 'like', '%'.$query.'%')
                        ->paginate(10);

        return view('authors.index', compact('authors'));
    }

    public function create()
    {
        return view('authors.create');
    }

    public function showView($id)
    {
        $author = Author::with('books')->findOrFail($id);

        return view('authors.show', compact('author'));
    }

    public function edit($id)
    {
        $author = Author::findOrFail($id);

        return view('authors.edit', compact('author'));
    }

    // Validation Method

    private function validateRequest(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'biography' => 'required|string',
            'date_of_birth' => 'required|date',
        ], [
            'name.required' => 'The name is required.',
            'biography.required' => 'The biography is required.',
            'date_of_birth.required' => 'The date of birth is required.',
            'date_of_birth.date' => 'The date of birth must be a valid date.',
        ]);
    }
}

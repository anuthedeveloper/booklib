<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AuthController;


// Routes

Route::get('/', [BookController::class, 'home'])->name('home');

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth'])->group(function () {
    // show pages
    Route::get('/books', [BookController::class, 'indexView'])->name('books.index');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/show/{id}', [BookController::class, 'showView'])->name('books.show');
    Route::get('/books/edit/{id}', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{id}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');

    Route::get('/authors', [AuthorController::class, 'indexView'])->name('authors.index');
    Route::get('/authors/create', [AuthorController::class, 'create'])->name('authors.create');
    Route::post('/authors', [AuthorController::class, 'store'])->name('authors.store');
    Route::get('/authors/show/{id}', [AuthorController::class, 'showView'])->name('authors.show');
    Route::get('/authors/edit/{id}', [AuthorController::class, 'edit'])->name('authors.edit');
    Route::put('/authors/{id}', [AuthorController::class, 'update'])->name('authors.update');
    Route::delete('/authors/{id}', [AuthorController::class, 'destroy'])->name('authors.destroy');
});
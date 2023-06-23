<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;

class BookService
{
    /*
     * Get all books
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Book::all();
    }

    /*
     * Get all books with deleted ones
     *
     * @return Collection
     */
    public function getAllWithTrashed(): Collection
    {
        return Book::withTrashed()->get();
    }

    /*
     * Call the Model to create and persist data
     *
     * @param array $data
     *
     * @return Book
     */
    public function store(array $data): Book
    {
        return Book::create($data);
    }

    /*
     * Update the received book with received data
     *
     * @param array $data
     * @param Book $book
     *
     * @return Book
     */
    public function update(array $data, Book $book): Book
    {
        $book->update($data);
        return $book;
    }

    /*
     * Delete the received book
     *
     * @param Book $book
     *
     * @return bool
     */
    public function delete(Book $book): bool
    {
        return $book->delete();
    }

}

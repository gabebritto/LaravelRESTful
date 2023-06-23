<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class BookController extends Controller
{
    /*
     * Returns the all books in JsonResource Collection
     *
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        return BookResource::collection(Book::all());
    }

    /*
     * Validates the received request and store a new book.
     *
     * @param BookRequest request
     *
     * @return JsonReponse
     */
    public function store(BookRequest $request): JsonResponse
    {
        return response()->json(new BookResource(Book::create($request->validated())), 201);
    }

    /*
     * Returns the solicitated book
     *
     * @param Book book
     *
     * @return JsonResource
     */
    public function show(Book $book): JsonResource
    {
        return new BookResource($book);
    }

    /*
     * Validates the received data and updates the referenced registry
     *
     * @param BookRequest $request
     * @param Book $book
     *
     * @return JsonResource
     */
    public function update(BookRequest $request, Book $book): JsonResource
    {
        $book->update($request->validated());

        return new BookResource($book);
    }

    /*
     * Deletes the referenced book
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(['message' => 'Book deleted.']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class BookController extends Controller
{
    private BookService $bookService;

    public function __construct (BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /*
     * Returns the all books in JsonResource Collection
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(['data' => BookResource::collection($this->bookService->getAll())]);
    }

    /*
     * Validates the received request and store a new book.
     *
     * @param BookRequest request
     *
     * @return JsonResponse
     */
    public function store(BookRequest $request): JsonResponse
    {
        return response()->json([
            'message' => 'Book created successfully',
            'data' => new BookResource($this->bookService->store($request->validated()))
        ], 201);
    }

    /*
     * Returns the solicitated book
     *
     * @param Book book
     *
     * @return JsonResponse
     */
    public function show(Book $book): JsonResponse
    {
        return response()->json(['data' => new BookResource($book)]);
    }

    /*
     * Validates the received data and updates the referenced registry
     *
     * @param BookRequest $request
     * @param Book $book
     *
     * @return JsonResponse
     */
    public function update(BookRequest $request, Book $book): JsonResponse
    {
        return response()->json([
            'message' => 'Book updated successfully',
            'data' => new BookResource($this->bookService->update($request->validated(), $book))
        ]);
    }

    /*
     * Deletes the referenced book
     *
     * @returns JsonResponse
     */
    public function destroy(Book $book): JsonResponse
    {
        $this->bookService->delete($book);

        return response()->json(['message' => 'Book deleted successfully.']);
    }
}

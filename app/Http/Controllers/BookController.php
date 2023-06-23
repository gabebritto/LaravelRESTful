<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

class BookController extends Controller
{
    private BookService $bookService;

    public function __construct (BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Return all books
     *
     * @OA\Get(
     *      path="/books",
     *      operationId="getBooksList",
     *      tags={"Books"},
     *      summary="Get list of books",
     *      description="Returns list of books",
     *      security={ {"bearer": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/BookResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index(): JsonResponse
    {
        return response()->json(['data' => BookResource::collection($this->bookService->getAll())]);
    }

    /**
     * Validates the received request and store a new book.
     *
     * @OA\Post(
     *      path="/books",
     *      operationId="storeBook",
     *      tags={"Books"},
     *      summary="Store new book",
     *      description="Returns stored book data",
     *      security={ {"bearer": {} }},
     *  @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="publication_date",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *       name="available_qty",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Book")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Content"
     *      )
     * )
     */
    public function store(BookRequest $request): JsonResponse
    {
        return response()->json([
            'message' => 'Book created successfully',
            'data' => new BookResource($this->bookService->store($request->validated()))
        ], 201);
    }

    /**
     *
     * Returns the solicitated book
     *
     * @OA\Get(
     *      path="/books/{book}",
     *      operationId="getBookById",
     *      tags={"Books"},
     *      summary="Get book information",
     *      description="Returns book data",
     *      security={ {"bearer": {} }},
     *      @OA\Parameter(
     *          name="book",
     *          description="Book id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Book")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource not found"
     *      )
     * )
     */
    public function show(Book $book): JsonResponse
    {
        return response()->json(['data' => new BookResource($book)]);
    }

    /**
     *
     * Validates the received data and updates the referenced registry
     *
     * @OA\Put(
     *      path="/books/{book}",
     *      operationId="updateBook",
     *      tags={"Books"},
     *      summary="Update existing book",
     *      description="Returns updated book data",
     *      security={ {"bearer": {} }},
     *      @OA\Parameter(
     *          name="book",
     *          description="Book id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/BookRequest")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  description="Message",
     *                  default="Book updated successfully"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Book"
     *              )
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function update(BookRequest $request, Book $book): JsonResponse
    {
        return response()->json([
            'message' => 'Book updated successfully',
            'data' => new BookResource($this->bookService->update($request->validated(), $book))
        ]);
    }

    /**
     *
     * Deletes the referenced book
     *
     * @OA\Delete(
     *      path="/books/{book}",
     *      operationId="deleteBook",
     *      tags={"Books"},
     *      summary="Delete book",
     *      description="Deletes book",
     *      security={ {"bearer": {} }},
     *      @OA\Parameter(
     *          name="book",
     *          description="Book id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  type="string",
     *                  description="Message",
     *                  default="Book deleted successfully.",
     *                  property="message"
     *              )
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource not found"
     *      )
     * )
     */
    public function destroy(Book $book): JsonResponse
    {
        $this->bookService->delete($book);

        return response()->json(['message' => 'Book deleted successfully.']);
    }
}

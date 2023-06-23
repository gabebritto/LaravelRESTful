<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      title="Book request",
 *      description="Book request body data",
 *      type="object",
 *      required={"name"},
 *     @OA\Property(format="string", title="name", description="Book name", example="Wonderland", property="name"),
 *     @OA\Property(format="string", title="publication_date", description="Book publication date in string", example="2020-03-10", property="publication_date"),
 *     @OA\Property(format="string", title="available_qty", description="Remaining books count", example="10", property="available_qty"),
 * )
 */
class BookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', Rule::unique('books')->ignore($this->id)],
            'publication_date' => ['required', 'date'],
            'available_qty' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

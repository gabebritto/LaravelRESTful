<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="BookResource",
 *     description="Book resource",
 *     @OA\Xml(
 *         name="BookResource"
 *     ),
 *   @OA\Property(property="data", type="array",
 *      @OA\Items(ref="#/components/schemas/Book"))
 *   ),
 * )
 *
 * @param  \Illuminate\Http\Request  $request
 * @return array
 */
class BookResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'publication_date' => $this->publication_date,
            'available_qty' => $this->available_qty,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

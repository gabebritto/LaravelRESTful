<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Book */
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

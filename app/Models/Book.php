<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Book",
 *     description="Book model",
 *     @OA\Xml(
 *         name="Book"
 *     ),
 *   @OA\Property(format="int64", title="ID", default=1, description="ID", property="id"),
 *   @OA\Property(format="string", title="name", description="Name", property="name"),
 *   @OA\Property(format="string", title="publication_date", description="Publication date", property="publication_date"),
 *   @OA\Property(format="string", title="available_qty", description="Available Quantity", property="available_qty")
 * )
 */
class Book extends Model
{
    use SoftDeletes;
    use hasFactory;

    protected $fillable = [
        'name',
        'publication_date',
        'available_qty',
    ];
}

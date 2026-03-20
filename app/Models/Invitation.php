<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{

    use HasFactory;

    /**
     * @OA\Schema(
     *     schema="Invitation",
     *     type="object",
     *     title="Invitation",
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="email", type="string", example="manager@test.com"),
     *     @OA\Property(property="organization_id", type="integer", example=1),
     *     @OA\Property(property="role", type="string", example="manager"),
     *     @OA\Property(property="token", type="string", example="uuid-token"),
     *     @OA\Property(property="status", type="string", example="pending")
     * )
     */

    protected $fillable = [
        'email',
        'organization_id',
        'role',
        'token',
        'status',
        'expires_at'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}

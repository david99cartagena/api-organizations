<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{

    use HasFactory;

    /**
     * @OA\Schema(
     *     schema="Organization",
     *     type="object",
     *     title="Organization",
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="name", type="string", example="Empresa Tech"),
     *     @OA\Property(property="owner_id", type="integer", example=1)
     * )
     */

    protected $fillable = [
        'name',
        'owner_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role')
            ->withTimestamps();
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
}

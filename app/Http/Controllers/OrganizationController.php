<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrganizationRequest;
use App\Models\Organization;
use Illuminate\Http\Request;
use Exception;

class OrganizationController extends BaseController
{
    /**
     * @OA\Post(
     *     path="/api/organizations",
     *     summary="Crear organización",
     *     tags={"Organizations"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Empresa Tech")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Organización creada"),
     *     @OA\Response(response=400, description="Error de validación"),
     *     @OA\Response(response=401, description="Sin permisos"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function store(StoreOrganizationRequest $request)
    {
        try {
            $user = auth()->user();

            $organization = Organization::create([
                'name' => $request->name,
                'owner_id' => $user->id
            ]);

            $organization->users()->attach($user->id, [
                'role' => 'admin'
            ]);

            return $this->success($organization, 'Organización creada correctamente', 201);
        } catch (\Exception $e) {
            return $this->error("Error interno del servidor: {$e->getMessage()}", 500);
        }
    }
}

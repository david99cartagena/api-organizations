<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcceptInvitationRequest;
use App\Http\Requests\StoreInvitationRequest;
use App\Mail\InvitationMail;
use App\Models\Invitation;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Validator;

class InvitationController extends BaseController
{
    /**
     * @OA\Post(
     *     path="/api/organizations/{id}/invitations",
     *     summary="Crear invitación",
     *     tags={"Invitations"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la organización",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","role"},
     *             @OA\Property(property="email", type="string", example="manager@test.com"),
     *             @OA\Property(property="role", type="string", example="manager")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Invitación creada",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Invitación creada correctamente"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="email", type="string", example="manager@test.com"),
     *                 @OA\Property(property="role", type="string", example="manager"),
     *                 @OA\Property(property="status", type="string", example="pending"),
     *                 @OA\Property(property="token", type="string", example="uuid-token"),
     *                 @OA\Property(property="expires_at", type="string", example="2026-03-21 12:00:00")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=400, description="Error de validación"),
     *     @OA\Response(response=401, description="Sin permisos"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function store(StoreInvitationRequest $request, $organizationId)
    {
        try {

            $user = auth()->user();
            $organization = Organization::findOrFail($organizationId);

            if (!$user->hasRoleInOrganization($organizationId, 'admin')) {
                return $this->unauthorized('No tienes permisos para invitar');
            }

            if ($organization->users()->where('email', $request->email)->exists()) {
                return $this->error('El usuario ya pertenece a la organización', 400);
            }

            if (Invitation::where('email', $request->email)
                ->where('organization_id', $organization->id)
                ->where('status', 'pending')
                ->exists()
            ) {
                return $this->error('Ya existe una invitación pendiente', 400);
            }

            $invitation = Invitation::create([
                'email' => $request->email,
                'organization_id' => $organization->id,
                'role' => $request->role,
                'token' => Str::uuid(),
                'status' => 'pending',
                'expires_at' => now()->addDays(2)
            ]);
            // Mail::to($invitation->email)->send(new InvitationMail($invitation));
            Mail::to($invitation->email)->queue(new InvitationMail($invitation));

            return $this->success($invitation, 'Invitación creada correctamente', 201);
        } catch (Exception $e) {
            return $this->error("Error interno del servidor: {$e->getMessage()}", 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/invitations/{token}",
     *     summary="Consultar invitación por token",
     *     tags={"Invitations"},
     *     @OA\Parameter(
     *         name="token",
     *         in="path",
     *         required=true,
     *         description="Token de la invitación",
     *         @OA\Schema(type="string", example="uuid-token")
     *     ),
     *     @OA\Response(response=200, description="Invitación encontrada"),
     *     @OA\Response(response=400, description="Invitación expirada o usada"),
     *     @OA\Response(response=404, description="No encontrada"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function show($token)
    {
        try {
            $invitation = Invitation::where('token', $token)->first();
            if (!$invitation) return $this->notFound('Invitación no encontrada');

            if ($invitation->expires_at && now()->gt($invitation->expires_at)) {
                $invitation->update(['status' => 'expired']);
                return $this->error('Invitación expirada', 400);
            }

            if ($invitation->status !== 'pending') {
                return $this->error('Invitación ya utilizada', 400);
            }

            return $this->success($invitation, 'Invitación encontrada');
        } catch (Exception $e) {
            return $this->error("Error interno del servidor: {$e->getMessage()}", 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/invitations/{token}/accept",
     *     summary="Aceptar invitación",
     *     tags={"Invitations"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="token",
     *         in="path",
     *         required=true,
     *         description="Token de la invitación",
     *         @OA\Schema(type="string", example="uuid-token")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="David"),
     *             @OA\Property(property="password", type="string", example="123456")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Invitación aceptada"),
     *     @OA\Response(response=400, description="Error de validación o invitación usada"),
     *     @OA\Response(response=404, description="Invitación no encontrada"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function accept(AcceptInvitationRequest $request, $token)
    {
        try {
            $invitation = Invitation::where('token', $token)->first();
            if (!$invitation) return $this->notFound('Invitación no válida');

            if ($invitation->expires_at && now()->gt($invitation->expires_at)) {
                $invitation->update(['status' => 'expired']);
                return $this->error('Invitación expirada', 400);
            }

            if ($invitation->status !== 'pending') {
                return $this->error('Invitación ya utilizada', 400);
            }

            $user = User::where('email', $invitation->email)->first();

            if (!$user) {
                // Forzamos validación manual usando Validator
                $data = $request->all();
                $data['user_missing'] = true;

                $validator = Validator::make($data, [
                    'name' => 'required_if:user_missing,true|string|max:255',
                    'password' => 'required_if:user_missing,true|min:6',
                ], [
                    'name.required_if' => 'El nombre es obligatorio para crear el usuario',
                    'password.required_if' => 'La contraseña es obligatoria para crear el usuario',
                    'password.min' => 'La contraseña debe tener al menos 6 caracteres',
                ]);

                if ($validator->fails()) {
                    return $this->error($validator->errors()->first(), 400);
                }

                $user = User::create([
                    'name' => $data['name'],
                    'email' => $invitation->email,
                    'password' => Hash::make($data['password'])
                ]);
            }

            if ($user->organizations()->where('organization_id', $invitation->organization_id)->exists()) {
                return $this->error('El usuario ya pertenece a la organización', 400);
            }

            $user->organizations()->syncWithoutDetaching([
                $invitation->organization_id => ['role' => $invitation->role]
            ]);

            $invitation->status = 'accepted';
            $invitation->save();

            return $this->success([
                'user' => $user,
                'organization_id' => $invitation->organization_id,
                'role' => $invitation->role
            ], 'Invitación aceptada correctamente');
        } catch (\Exception $e) {
            return $this->error("Error interno del servidor: {$e->getMessage()}", 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class AuthController extends BaseController
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Registrar usuario",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string", example="David"),
     *             @OA\Property(property="email", type="string", example="david@test.com"),
     *             @OA\Property(property="password", type="string", example="123456")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Usuario creado"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function register(RegisterUserRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $token = auth()->login($user);

            return $this->success([
                'user' => $user,
                'token' => $token
            ], 'Usuario registrado exitosamente', 201);
        } catch (Exception $e) {
            return $this->error("Error interno del servidor: {$e->getMessage()}", 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login usuario",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", example="david@test.com"),
     *             @OA\Property(property="password", type="string", example="123456")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Login exitoso"),
     *     @OA\Response(response=401, description="Credenciales incorrectas"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function login(LoginUserRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (!$token = auth()->attempt($credentials)) {
                return $this->unauthorized('Credenciales incorrectas');
            }

            return $this->success(['token' => $token], 'Login exitoso');
        } catch (Exception $e) {
            return $this->error("Error interno del servidor: {$e->getMessage()}", 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/me",
     *     summary="Usuario autenticado",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Usuario autenticado"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function me()
    {
        try {
            return $this->success(auth()->user(), 'Usuario autenticado');
        } catch (Exception $e) {
            return $this->error("Error interno del servidor: {$e->getMessage()}", 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Cerrar sesión",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Logout exitoso"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function logout()
    {
        try {
            auth()->logout();
            return $this->success(null, 'Sesión cerrada exitosamente');
        } catch (Exception $e) {
            return $this->error("Error interno del servidor: {$e->getMessage()}", 500);
        }
    }
}

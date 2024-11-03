<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Realiza a autenticação do usuário e retorna um token personalizado
     * para requisições autenticadas.
     *
     * @param \App\Http\Requests\AuthRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json(["message" => "Não Autenticado!"], 401);
        }

        $user = $request->user();
        $expiresAt = $request->remember ? now()->addYear() : now()->addMonth();

        $token = $user->createToken("Personal Access Token", ["*"], $expiresAt)->plainTextToken;

        return response()->json([
            "token" => $token,
        ], 200);
    }

    /**
     * Desloga o usuário removendo seus tokens de acesso.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        Session::flush();

        Session::regenerate();

        return response()->json([
            'message' => 'Deslogado com sucesso!'
        ], 200);
    }

    /**
     * Retorna o usuário autenticado.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}

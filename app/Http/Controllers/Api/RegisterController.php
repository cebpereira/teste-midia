<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{

    public function register(RegisterRequest $request)
    {

        try {
            $data = $request->data();

            $user = User::create($data);

            throw_if(
                !$user,
                "Não foi possível criar o usuário.",
            );

            $this->response->setData($user)->setStatusCode(200);
        } catch (\Exception $e) {
            return response()->json([
                "error" => "Erro ao criar o documento.",
                "message" => $e->getMessage()
            ], 500);
        }
    }
}

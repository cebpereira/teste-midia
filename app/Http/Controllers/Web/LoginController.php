<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller
{
    private $authController;

    public function __construct()
    {
        $this->authController = new AuthController();
    }

    public function index()
    {
        if (Auth::check()) {
            return redirect()->route("dashboard");
        }

        return Inertia::render('Auth/Login');
    }

    public function login(AuthRequest $request)
    {
        $response = $this->authController->login($request);

        if ($response->status() === 200) {
            return response()->json(['success' => 'Usuário logado com sucesso!'], 200);
        } else {
            return response()->json(['error' => 'E-mail e/ou senha incorreto(s)'], 422);
        }
    }

    public function logout(Request $request)
    {
        $response = $this->authController->logout($request);

        Auth::guard('web')->logout();

        return redirect()->route('login');
    }
}

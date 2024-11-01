<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @var JsonResponse $responso
     */
    protected $response;

    public function __construct()
    {
        $this->response = response()->json();
        $this->response->setStatusCode(204);
    }

    /**
     * Recupera a model do usuário logado no momento.
     */
    public function getUser(): User
    {
        return User::find(Auth::id());
    }
}

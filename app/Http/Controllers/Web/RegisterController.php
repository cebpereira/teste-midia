<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Inertia\Inertia;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{

    public function index()
    {
        if (Auth::check()) {
            return redirect()->route("dashboard");
        }

        return Inertia::render('Auth/Register');
    }
}

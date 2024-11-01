<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = $this->getUser();

        $documents = $user->documents()->get();

        return Inertia::render('Dashboard', [
            'documents' => $documents,
        ]);
    }
}

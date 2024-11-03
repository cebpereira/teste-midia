<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = $this->getUser();

        $documents = $user->documents()->get()->only(['document_id', 'title', 'user_name', 'user_role', 'product_brand', 'file_path']);

        return Inertia::render('Dashboard', [
            'documents' => $documents,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class DocumentController extends Controller
{

    public function index()
    {
        $user = $this->getUser();

        $documents = $user->documents()->get();

        return Inertia::render('Dashboard', ['documents' => $documents]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Documents/DocumentForm', [
            'documentData' => null
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->getUser();

        $document = $user->documents()->find($id);

        throw_if(!$document, 'Document não encontrado.');

        return Inertia::render('Documents/Show', [
            'document' => $document
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = $this->getUser();

        $document = $user->documents()->find($id);

        throw_if(!$document, 'Document não encontrado.');

        return Inertia::render('Documents/DocumentForm', [
            'documentData' => $document
        ]);
    }
}

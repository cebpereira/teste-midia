<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use Inertia\Inertia;

use App\Models\Document;

class DocumentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Documents/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DocumentRequest $request)
    {
        $data = $request->data();

        $document = Document::create($data);

        throw_if(!$document, 'Document not created');

        return redirect()->route('documents.index')->with('success', 'Documento criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->getUser();

        $document = $user->documents()->find($id);

        throw_if(!$document, 'Document not found');

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

        throw_if(!$document, 'Document not found');

        return Inertia::render('Documents/Edit', [
            'document' => $document
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DocumentRequest $request, string $id)
    {
        $data = $request->data();

        $document = Document::find($id);

        throw_if(!$document, 'Document not found');

        $document->update($data);

        return redirect()->route('documents.index')->with('success', 'Documento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $document = Document::find($id);

        throw_if(!$document, 'Document not found');

        $document->delete($id);

        return redirect()->route('documents.index')->with('success', 'Documento excluído com sucesso!');
    }
}

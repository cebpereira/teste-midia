<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentRequest;
use App\Models\Document;
use App\Helpers\QueryHelper;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;

class DocumentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(DocumentRequest $request)
    {
        try {
            $data = $request->data();

            $filePath = $this->createDocument($data);

            $document = Document::create(array_merge($data, ['file_path' => $filePath]));

            return response()->json(['message' => 'Documento criado com sucesso!', 'file' => $filePath, 'data' => $document]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => "Erro ao criar o documento.",
                "message" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exibe o documento de acordo com o id informado.
     *
     * @param string $id
     * @return \App\Helpers\ApiResponse
     */
    public function show(string $id)
    {
        try {
            $user = $this->getUser();

            $document = $user->documents->find($id);

            throw_if(
                !$document,
                'Não foi possível encontrar o documento.',
            );

            $this->response->setData($document)->setStatusCode(200);
        } catch (\Exception $e) {
            $this->response->setData([
                "error" => "Erro ao buscar o documento.",
                "message" => $e->getMessage()
            ])->setStatusCode(500);
        }

        return $this->response;
    }

    /**
     * Recupera os Objetivos com base nos parâmetros informados.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Helpers\ApiResponse
     */
    public function find(Request $request)
    {
        try {
            $query = new QueryHelper();

            $inputs = $request->input();

            $documents = $query($inputs, Document::class);

            throw_if(
                !$documents,
                'Não foi possível encontrar documentos vinculados a este usuário.',
            );

            $this->response->setData($documents)->setStatusCode(200);
        } catch (\Exception $e) {
            $this->response->setData([
                "error" => "Erro ao buscar documentos.",
                "message" => $e->getMessage()
            ])->setStatusCode(500);
        }

        return $this->response;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DocumentRequest $request, string $id)
    {
        try {
            $data = $request->validated();

            $document = Document::findOrFail($id);

            $templateContent = Storage::get($document->file_path);

            $content = $this->replaceVariables($templateContent, $data);

            Storage::put($document->file_path, $content);

            $document->update($data);

            return response()->json(['message' => 'Documento atualizado com sucesso!', 'data' => $document]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => "Erro ao atualizar o documento.",
                "message" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        try {
            $document = Document::find($id);

            throw_if(!$document, 'Documento não encontrado.');

            $document->delete();
        } catch (\Exception $e) {
            $this->response->setData([
                "error" => "Erro ao deletar o documento.",
                "message" => $e->getMessage()
            ])->setStatusCode(500);
        }

        return $this->response;
    }


    /**
     * Função para criar um documento Word e salvar como DOCX.
     */
    public function createDocument(array $data)
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $section->addText("Nome do Usuário: {$data['user_name']}");
        $section->addText("Cargo do Usuário: {$data['user_role']}");
        $section->addText("Nome do Produto: {$data['product_brand']}");

        $fileName = 'document_' . time() . '.docx';
        $filePath = storage_path("app/documents/{$fileName}");
        $phpWord->save($filePath, 'Word2007');

        return "documents/{$fileName}";
    }


    /**
     * Função auxiliar para converter um arquivo DOCX para PDF usando PHPWord.
     */
    private function convertDocxToPdf($docxPath, $pdfPath)
    {
        $phpWord = IOFactory::load($docxPath);

        $pdfWriter = IOFactory::createWriter($phpWord, 'PDF');
        $pdfWriter->save($pdfPath);
    }


    /**
     * Método para download do documento, seja como DOCX ou PDF.
     */
    public function download($id, Request $request)
    {
        $document = Document::findOrFail($id);

        $format = $request->query('format', 'pdf');
        $filePath = $document->file_path;

        if ($format === 'pdf') {
            $pdfPath = str_replace('.docx', '.pdf', $filePath);
            if (!Storage::exists($pdfPath)) {
                $this->convertDocxToPdf(storage_path("app/{$filePath}"), storage_path("app/{$pdfPath}"));
            }
            $filePath = $pdfPath;
        }

        return response()->download(storage_path("app/{$filePath}"));
    }


    /**
     * Substitui as variáveis de um template com os valores informados.
     *
     * @param string $content Conteúdo do template.
     * @param array $data Valores a serem substituídos.
     * @return string O conteúdo do template com as variáveis substituídas.
     */
    private function replaceVariables($content, $data)
    {
        foreach ($data as $key => $value) {
            $content = str_replace('${' . $key . '}', $value, $content);
        }
        return $content;
    }
}

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
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(DocumentRequest $request)
    {
        try {
            $data = $request->data();
            $data['file_path'] = null;

            $document = Document::create($data);

            throw_if(
                !$document,
                'Não foi possível criar o documento.',
            );

            return response()->json(['message' => 'Documento criado com sucesso!', 'data' => $document]);
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

            $user = $this->getUser();

            $documents = $user->documents()->get();

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
            $data = $request->data();

            $user = $this->getUser();

            $document = $user->documents()->find($id);

            throw_if(
                !$document,
                'Documento não encontrado.'
            );

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
            $user = $this->getUser();

            $document = $user->documents()->find($id);

            throw_if(
                !$document,
                'Documento não encontrado.'
            );

            $document->delete();

            return response()->json(['message' => 'Documento excluído com sucesso'], 200);
        } catch (\Exception $e) {
            $this->response->setData([
                "error" => "Erro ao deletar o documento.",
                "message" => $e->getMessage()
            ])->setStatusCode(500);
        }

        return $this->response;
    }

    /**
     * Gera e baixa o documento no formato especificado.
     *
     * @param string $id
     * @param string $format
     * @return \Illuminate\Http\Response
     */
    public function download($id, $format = 'docx')
    {
        try {
            $user = $this->getUser();
            $document = $user->documents()->find($id);

            throw_if(
                !$document,
                'Documento não encontrado.'
            );

            if ($document->file_path && Storage::exists($document->file_path)) {
                Storage::delete($document->file_path);
                $document->file_path = null;
            }

            $templatePath = storage_path('app/templates/anexo1.docx');
            if (!file_exists($templatePath)) {
                throw new \Exception("Modelo de documento não encontrado.");
            }

            $templateProcessor = new TemplateProcessor($templatePath);
            $this->replaceTemplateVariables($templateProcessor, $document->toArray());

            $fileName = "document_{$id}";
            $outputPath = "documents/{$fileName}";

            // TODO: Resolver erros ao gerar arquivo em PDF
            if ($format === 'pdf') {
                $tempDocxPath = storage_path("app/documents/temp_{$fileName}.docx");
                $templateProcessor->saveAs($tempDocxPath);

                $outputPath .= ".pdf";
                $pdf = Pdf::loadFile($tempDocxPath);
                Storage::put($outputPath, $pdf->output());

                unlink($tempDocxPath);
            } else {
                $outputPath .= ".docx";
                $templateProcessor->saveAs(storage_path("app/{$outputPath}"));
            }

            $document->update(['file_path' => $outputPath]);

            return Storage::download($outputPath, "{$fileName}.{$format}");
        } catch (\Exception $e) {
            return response()->json([
                "error" => "Erro ao baixar o documento.",
                "message" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Substitui variáveis no template com os dados do documento.
     *
     * @param TemplateProcessor $templateProcessor
     * @param Document $document
     * @return void
     */
    private function replaceTemplateVariables(TemplateProcessor $templateProcessor, array $data)
    {
        foreach ($data as $key => $value) {
            if (!is_null($value)) {
                $templateProcessor->setValue($key, $value);
            }
        }
    }
}

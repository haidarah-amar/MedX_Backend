<?php

namespace App\Services;

use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Repositories\Contracts\DocumentRepositoryInterface;
use App\Services\Contracts\DocumentServiceInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentService implements DocumentServiceInterface
{
    public function __construct(
        private DocumentRepositoryInterface $documentRepository
    ) {}

    public function index(int $clinicId)
    {
        return response()->json(
            $this->documentRepository->index($clinicId)
        );
    }

    public function show(int $clinicId, int $id)
    {
        $document = $this->documentRepository->find($clinicId, $id);

        if (!$document) {
            return response()->json([
                'message' => 'Document not found.'
            ], 404);
        }

        return response()->json($document);
    }

    public function store(int $clinicId, StoreDocumentRequest $request)
    {
        $file = $request->file('file');

        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs(
            'documents',
            $filename,
            'public'
        );

        $document = $this->documentRepository->store([
            'clinic_id'   => $clinicId,
            'title'       => $request->title,
            'category'    => $request->category,
            'description' => $request->description,
            'file'        => $path,
        ]);

        return response()->json([
            'message' => 'Document created successfully.',
            'data' => $document
        ], 201);
    }

    public function update(int $clinicId, UpdateDocumentRequest $request, int $id)
    {
        $document = $this->documentRepository->find($clinicId, $id);

        if (!$document) {
            return response()->json([
                'message' => 'Document not found.'
            ], 404);
        }

        $data = [
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
        ];

        if ($request->hasFile('file')) {

            Storage::disk('public')->delete($document->file);

            $file = $request->file('file');

            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $data['file'] = $file->storeAs(
                'documents',
                $filename,
                'public'
            );
        }

        $this->documentRepository->update($document, $data);

        return response()->json([
            'message' => 'Document updated successfully.',
            'data' => $document->fresh()
        ]);
    }

    public function destroy(int $clinicId, int $id)
    {
        $document = $this->documentRepository->find($clinicId, $id);

        if (!$document) {
            return response()->json([
                'message' => 'Document not found.'
            ], 404);
        }

        Storage::disk('public')->delete($document->file);

        $this->documentRepository->delete($document);

        return response()->json([
            'message' => 'Document deleted successfully.'
        ]);
    }
}
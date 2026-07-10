<?php

namespace App\Http\Controllers\ClinicControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Services\Contracts\DocumentServiceInterface;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function __construct(
        private DocumentServiceInterface $documentService
    ) {}

    public function index()
    {
        $clinic_id = Auth::user()->id;
        return $this->documentService->index($clinic_id);
    }

    public function show(int $id)
    {
        $clinic_id = Auth::user()->id;
        return $this->documentService->show($clinic_id, $id);
    }

    public function store(StoreDocumentRequest $request)
    {
        $clinic_id = Auth::user()->id;
        return $this->documentService->store($clinic_id, $request);
    }

    public function update(UpdateDocumentRequest $request, int $id)
    {
        $clinic_id = Auth::user()->id;
        return $this->documentService->update($clinic_id, $request, $id);
    }

    public function destroy(int $id)
    {
        $clinic_id = Auth::user()->id;
        return $this->documentService->destroy($clinic_id, $id);
    }
}

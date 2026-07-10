<?php

namespace App\Repositories;

use App\Models\Document;
use App\Repositories\Contracts\DocumentRepositoryInterface;

class DocumentRepository implements DocumentRepositoryInterface
{
    public function index(int $clinicId)
    {
        return Document::whereClinicId($clinicId)
            ->latest()
            ->get();
    }

    public function find(int $clinicId, int $id): ?Document
    {
        return Document::whereClinicId($clinicId)
            ->whereId($id)
            ->first();
    }

    public function store(array $data): Document
    {
        return Document::create($data);
    }

    public function update(Document $document, array $data): bool
    {
        return $document->update($data);
    }

    public function delete(Document $document): bool
    {
        $id =$document->id;
        return $document->delete($id);
    }
}
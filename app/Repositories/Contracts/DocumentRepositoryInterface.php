<?php

namespace App\Repositories\Contracts;

use App\Models\Document;

interface DocumentRepositoryInterface
{
    public function index(int $clinicId);

    public function find(int $clinicId, int $id): ?Document;

    public function store(array $data): Document;

    public function update(Document $document, array $data): bool;

    public function delete(Document $document): bool;
}
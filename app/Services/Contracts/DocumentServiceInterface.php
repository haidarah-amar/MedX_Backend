<?php

namespace App\Services\Contracts;

use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;

interface DocumentServiceInterface
{
    public function index(int $clinicId);

    public function show(int $clinicId, int $id);

    public function store(int $clinicId, StoreDocumentRequest $request);

    public function update(int $clinicId, UpdateDocumentRequest $request, int $id);

    public function destroy(int $clinicId, int $id);
}
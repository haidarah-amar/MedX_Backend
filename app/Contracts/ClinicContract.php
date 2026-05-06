<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface ClinicContract
{
    public function getClinicById($id);

    public function getAllClinics();

    public function createClinic(array $data);

    public function updateClinic($id, array $data);

    public function deleteClinic($id);

    public function login(array $credentials);

    public function logout();

    public function getAuthenticatedClinic();

    public function activateClinic($id);

    public function uploadImages($clinicId, $images);
}
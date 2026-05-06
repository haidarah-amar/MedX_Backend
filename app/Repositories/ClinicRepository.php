<?php

namespace App\Repositories;

use App\Contracts\ClinicContract;
use App\Models\Clinic;
use App\Models\ClinicImage;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWTGuard;

class ClinicRepository implements ClinicContract
{
    
    public function getClinicById($id)
    {
        return Clinic::findOrFail($id);
    }

    public function getAllClinics()
    {
        return Clinic::all();
    }

    public function createClinic(array $data)
    {
        if (isset($data['owner_idphoto'])) {
            $data['owner_idphoto'] = $data['owner_idphoto']
                ->store('owners', 'public');
        }

        if (isset($data['logo'])) {
            $data['logo'] = $data['logo']
                ->store('clinics', 'public');
        }

        $data['password'] = bcrypt($data['password']);

        return Clinic::create($data);
    }

    public function updateClinic($id, array $data)
    {
        $clinic = $this->getClinicById($id);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        if (isset($data['owner_idphoto'])) {
            $data['owner_idphoto'] = $data['owner_idphoto']
                ->store('owners', 'public');
        }

        if (isset($data['logo'])) {
            $data['logo'] = $data['logo']
                ->store('clinics', 'public');
        }

        $clinic->update($data);

        return $clinic;
    }

    public function deleteClinic($id)
    {
        $clinic = $this->getClinicById($id);

        return $clinic->delete();
    }

    public function login(array $credentials)
{
    $clinic = Clinic::where('email', $credentials['email'])->first();

    if (
        !$clinic ||
        !Hash::check($credentials['password'], $clinic->password)
    ) {
        return null;
    }

    if (!$clinic->is_approved) {
        return false;
    }

    $token = JWTAuth::fromUser($clinic);

    return [
        'clinic' => $clinic,
        'token' => $token,
    ];
}

    public function logout()
    {
        $token = JWTAuth::getToken();

        if (!$token) {
            return false;
        }

        JWTAuth::invalidate($token);

        return true;
    }

    public function getAuthenticatedClinic()
    {
        return auth('clinic-api')->user();
    }

    public function activateClinic($id)
    {
        $clinic = $this->getClinicById($id);

        $clinic->is_active = !$clinic->is_active;

        $clinic->save();

        return $clinic;
    }

    public function uploadImages($clinicId, $images)
    {
        $uploadedImages = [];

        foreach ($images as $image) {

            $path = $image->store('clinics', 'public');

            $uploadedImages[] = ClinicImage::create([
                'clinic_id' => $clinicId,
                'image_path' => $path,
            ]);
        }

        return $uploadedImages;
    }
}
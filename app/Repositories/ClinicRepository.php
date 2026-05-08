<?php

namespace App\Repositories;

use App\Models\Clinic;
use App\Models\ClinicImage;
use App\Repositories\Contracts\ClinicRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class ClinicRepository implements ClinicRepositoryInterface
{
    public function findById(int $id)
    {
        return Clinic::findOrFail($id);
    }

    public function findByEmail(string $email)
    {
        return Clinic::findOrFail('email', $email)->first();
    }

    public function all()
    {
        return Clinic::all();
    }

    public function create(array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        return Clinic::create($data);
    }

    public function update(int $id, array $data)
    {
        $clinic = $this->findById($id);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $clinic->update($data);

        return $clinic;
    }

    public function delete(int $id)
    {
        return $this->findById($id)->delete();
    }

 public function login(array $credentials)
{
    $clinic = Clinic::findOrFail('email', $credentials['email'])->first();

    if (!$clinic || !Hash::check($credentials['password'], $clinic->password)) {
        return null;
    }

    if (!$clinic->is_approved) {
        return false;
    }

    $token = JWTAuth::fromUser($clinic);

    return [
        'token' => $token,
        'clinic' => $clinic
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

    public function activateClinic(int $id)
    {
        $clinic = $this->findById($id);

        $clinic->is_active = !$clinic->is_active;

        $clinic->save();

        return $clinic;
    }

    public function uploadImages(int $clinicId, array $images)
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
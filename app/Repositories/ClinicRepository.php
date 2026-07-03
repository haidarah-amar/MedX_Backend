<?php

namespace App\Repositories;

use App\Models\Clinic;
use App\Models\ClinicImage;
use App\Models\Department;
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
        return Clinic::where('email', $email)->first();
    }

    public function all()
    {
        return Clinic::latest()->paginate(10);
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
        $clinic = Clinic::whereEmail($credentials['email'])->first();

        if (! $clinic || ! Hash::check($credentials['password'], $clinic->password)) {
            return null;
        }

        if (! $clinic->isApproved()) {
            return false;
        }

        if (! $clinic->is_active) {
            return 'inactive';
        }

        $token = JWTAuth::fromUser($clinic);

        return [
            'token' => $token,
            'clinic' => $clinic,
        ];
    }

    public function logout()
    {
        $token = JWTAuth::getToken();

        if (! $token) {
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

        $clinic->is_active = ! $clinic->is_active;

        $clinic->save();

        return $clinic;
    }

    public function approve(int $id)
    {
        $clinic = $this->findById($id);

        $clinic->update([
            'is_approved' => true,
            'approval_status' => Clinic::STATUS_APPROVED,
            'rejection_reason' => null,
            'is_active' => true,
        ]);

        return $clinic->refresh();
    }

    public function reject(int $id, ?string $reason = null)
    {
        $clinic = $this->findById($id);

        $clinic->update([
            'is_approved' => false,
            'approval_status' => Clinic::STATUS_REJECTED,
            'rejection_reason' => $reason,
            'is_active' => false,
        ]);

        return $clinic->refresh();
    }

    public function stop(int $id)
    {
        $clinic = $this->findById($id);

        $clinic->update(['is_active' => false]);

        return $clinic->refresh();
    }

    public function start(int $id)
    {
        $clinic = $this->findById($id);

        abort_if(
            ! $clinic->isApproved(),
            422,
            __('messages.clinic_must_be_approved')
        );

        $clinic->update(['is_active' => true]);

        return $clinic->refresh();
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

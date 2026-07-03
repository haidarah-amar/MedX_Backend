<?php

namespace App\Repositories;

use App\Models\Favorite;

class FavoriteRepository
{
    public function toggle($userId, $clinicId): bool
    {
        $favorite = Favorite::where('user_id', $userId)
            ->where('clinic_id', $clinicId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return false; // removed
        }

        Favorite::create([
            'user_id' => $userId,
            'clinic_id' => $clinicId,
        ]);

        return true; // added
    }

    public function getAllFavoritesByUserId($userId)
    {
        return Favorite::where('user_id', $userId)->with('clinic')->paginate(10);
    }
}
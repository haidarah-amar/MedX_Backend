<?php

namespace App\Services;

use App\Repositories\FavoriteRepository;

class FavoriteService {
    public function __construct(
        private FavoriteRepository $favoriteRepository
    ) {}

    public function toggle($userId , $clinicId)
    {
        $added = $this->favoriteRepository->toggle(
            $userId,
            $clinicId
        );

        return [
            'status' => true,
            'message' => $added
                ? 'Clinic added to favorites.'
                : 'Clinic removed from favorites.',
            'is_favorite' => $added,
        ];
    }

    public function getAllFavoritesByUserId($userId)
    {
        return $this->favoriteRepository->getAllFavoritesByUserId($userId);
    }

}
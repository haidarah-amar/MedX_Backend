<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\FavoriteService as FavoriteService;

class FavoriteController extends Controller
{

    public function toggle($clinicId)
{

        $userId = Auth::id();

        $result = app('App\Services\FavoriteService')->toggle($userId, $clinicId);

        return response()->json($result);
    }

    public function getAllFavoritesByUserId()
    {
        $userId = Auth::id();

        $favorites = app('App\Services\FavoriteService')->getAllFavoritesByUserId($userId);

        return response()->json($favorites);
    }


}

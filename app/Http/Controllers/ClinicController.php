<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreClinicRequest;
use App\Http\Requests\UpdateClinicRequest;
use App\Models\Clinic;
use App\Models\ClinicImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
class ClinicController extends Controller
{

    public function store(StoreClinicRequest $request)
{
    $data = $request->validated();

    if ($request->hasFile('owner_idphoto')) {
    $data['owner_idphoto'] = $request->file('owner_idphoto')->store('owners', 'public');
    }

    if ($request->hasFile('logo')) {
    $data['logo'] = $request->file('logo')->store('clinics', 'public');
    }

    $clinic = Clinic::create([
        ...$data,
        'password' => bcrypt($request->password)
    ]);

    return response()->json([
        'message' => 'تم تسجيل العيادة بنجاح، سيتم ابلاغكم عبر الايميل المدخل في حسابكم فور تفعيل حسابكم من قبل الحكومة',
        'clinic' => $clinic
    ], 201);
}

    public function login(LoginRequest $request)
{
    $credentials = $request->only('email', 'password');

    if (!$token = JWTAuth::attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $user = JWTAuth::user();

    if (!$user->is_approved) {
        JWTAuth::invalidate($token);

        return response()->json([
            'error' => 'لم يتم تفعيل حسابك من قبل الحكومة بعد، سيتم ابلاغكم فور تفعيله عبر الايميل المدخل في حسابكم'
        ], 403);
    }

    return response()->json([
        'token' => $token,
        'clinic' => $user
    ], 200);
}


  public function logout(Request $request)
{
    $token = JWTAuth::getToken();

    if (!$token) {
        return response()->json(['message' => 'Token not found'], 400);
    }

    JWTAuth::invalidate($token);

    return response()->json([
        'message' => 'تم تسجيل الخروج بنجاح'
    ]);
}



public function show()
{
    return response()->json(auth('api')->user());
}


public function update(UpdateClinicRequest $request)
{
    $clinic = auth('api')->user();
    
    if ($request->password) {
    $clinic->password = bcrypt($request->password);
    }

    if ($request->hasFile('owner_idphoto')) {
    $clinic['owner_idphoto'] = $request->file('owner_idphoto')->update('owners', 'public');
    }

    $clinic->update($request->validated());

    return response()->json(['message' => 'تم تحديث بيانات العيادة بنجاح', 'clinic' => $clinic] , 200);
}

public function activate()
{
    $clinic = auth('api')->user();

    $clinic->is_active = ! $clinic->is_active;
    $clinic->save();

    return response()->json([
        'message' => 'تم تحديث حالة العيادة بنجاح',
        'is_active' => $clinic->is_active
    ]);
}

public function uploadImage(Request $request)
{
     $request->validate([
        'images' => 'required',
        'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $clinic = auth('api')->user();

    $uploadedImages = [];

    foreach ($request->file('images') as $image) {
        $path = $image->store('clinics', 'public');

        $uploadedImages[] = ClinicImage::create([
            'clinic_id' => $clinic->id,
            'image_path' => $path,
        ]);
    }

    return response()->json([
        'message' => 'تمت اضافة الصور بنجاح',
        'data' => $uploadedImages
    ]);
}



}
